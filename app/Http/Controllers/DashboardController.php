<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Supply;
use App\Models\CartItem;
use App\Models\Requisition;
use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PmrExport;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole(['admin','finance_officer','supply_officer']) && !$request->shop) {
            $supply = Supply::count();
            $po = PurchaseOrder::count();
            $pr = PurchaseRequest::count();

            $pr_amount = PurchaseRequest::join('purchase_request_items as i','i.purchase_request_id','purchase_requests.id')
                                        ->join('cart_items as c','c.id','i.cart_item_id')
                                        ->sum('unit_cost');

            $po_amount = PurchaseOrder::join('purchase_order_items as pi','pi.purchase_order_id','purchase_orders.id')
                                      ->join('purchase_request_items as i','i.id','pi.purchase_request_item_id')
                                      ->join('cart_items as c','c.id','i.cart_item_id')
                                      ->where('purchase_orders.is_active',0)
                                      ->sum('unit_cost');

            $quals = Qualification::with('purchase_requests.items.cart_item')
                                ->withCount('purchase_requests')
                                ->orderBy('name')
                                ->get();
            

            return view('dashboard.homepage',compact('supply','po','pr','po_amount','quals'));
        }

        $quals = Qualification::get();
        if(!auth()->user()->hasRole('admin')) {
            $supplies = Supply::where('qualification_id',auth()->user()->qualification_id)->latest()->get();
        } else {
            $supplies = Supply::latest()->get();
        }
        
        if(isset($request->qualification)) {
            $supplies = $supplies->where('qualification_id',$request->qualification);
        }

        $cart = Cart::active(auth()->user()->id)->first();
        return view('user.dashboard',compact('quals','supplies'));
    }

    public function search(Request $request)
    {
        if(!auth()->user()->hasRole('admin')) {
            $supplies = Supply::latest()->search($request)->where('qualification_id',auth()->user()->qualification_id)->get();
        } else {
            $supplies = Supply::latest()->search($request)->get();
        }
        return view('user._supply_table',compact('supplies'))->render();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function pmr(Request $request) 
    {                       
        $pr = PurchaseRequestItem::with('purchase_request')
                                ->join('purchase_requests as pr','pr.id','purchase_request_items.purchase_request_id')
                                ->join('cart_items as cart_item','cart_item.id','purchase_request_items.cart_item_id')
                                ->join('supplies as sup','sup.id','cart_item.supply_id')
                                ->leftjoin('purchase_orders as po','po.purchase_request_id','pr.id')
                                ->select('sup.name as supply_name','purchase_request_items.purchase_request_id','pr.created_at as pr_created_at','po.created_at as po_created_at','purchase_request_items.status as pr_item_status','cart_item.quantity','cart_item.unit_cost','purchase_request_items.id as pr_item_id');

        if($request->month) {
            $pr = $pr->whereMonth('pr.created_at',$request->month);
        }

        $pr = $pr->get()->unique('pr_item_id');

        if($request->report) {
            return Excel::download(new PmrExport($pr), 'Pmr.xlsx');
        }

        $month = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        return view('dashboard.pmr',compact('pr','month','request'));
    }
}
