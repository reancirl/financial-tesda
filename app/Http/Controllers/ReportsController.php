<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\Requisition;
use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Exports\PurchaseOrderExport;
use App\Exports\PurchaseRequestExport;

class ReportsController extends Controller
{
    public function index()
    {
        $quals = Qualification::get();
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        return view('reports.index',compact('quals','months'));
    }

    public function purchaseRequest(Request $request)
    {
        $data = PurchaseRequest::where('qualification_id',$request->qualification)
                               ->whereYear('created_at',now()->year);

        if($request->month != 'latest') {            
            $data = $data->whereMonth('created_at',$request->month);
        }

        if($request->item_status != 'All') {
            $item_status = $request->item_status;
            $data = $data->with(['items' => function($q) use($item_status) {
                                $q->where('status', '=', $item_status);
                            }])->with('qualification');
        } else {
            $data = $data->with('items','qualification');
        }

        $data = $data->latest()->first();
        
        return Excel::download(new PurchaseRequestExport($data), 'Purchase Request Report'.'.xlsx');
    }

    public function purchaseOrder(Request $request)
    {
        $data = Requisition::join('users as u','u.id','requisitions.user_id')
                           ->join('qualifications as q','q.id','u.qualification_id')
                           ->join('carts as c','c.id','requisitions.cart_id')
                           ->join('cart_items as i','i.cart_id','c.id')
                           ->join('supplies as s','s.id','i.supply_id')
                           ->select('requisitions.id','u.name as user_name','q.name as qualification_name','s.unit','s.name as item_name','i.quantity','i.unit_cost')
                           ->where('u.qualification_id',$request->qualification)
                           ->whereYear('requisitions.created_at',now()->year);
        
        if($request->month != 'latest') {            
            $data = $data->whereMonth('requisitions.created_at',$request->month);
        }

        $data = $data->get();

        return Excel::download(new PurchaseOrderExport($data), 'Purchase Order Report'.'.xlsx');
    }

    public function qualification()
    {
        //
    }
}
