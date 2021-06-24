<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Bidding;
use App\Models\BiddingItem;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseRequest as Pr;
use App\Exports\Rfq;

class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $prs = PurchaseRequest::with('user','qualification','items')->latest()->get();
        return view('purchase-request.index',compact('request','prs'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function edit(Request $request,$id)
    {
        $pr = PurchaseRequest::with('user','qualification','items.cart_item.supply.qualification')
                            ->withCount('completed')
                            ->findOrFail($id);

        $suppliers = Supplier::get();
        
        if($request->rfq) {
            return Excel::download(new Rfq($pr), 'Rfq.xlsx');
        }

        if($request->report) {
            return Excel::download(new Pr($pr), 'Purchase Request.xlsx');
        }

        return view('purchase-request.edit',compact('pr','suppliers','request'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $pr = PurchaseRequest::findOrFail($id);
        $pr->fund_cluster = $request->fund_cluster;
        $pr->save();

        $done = 0;
        $pr_items_count = 0;

        foreach($request->item_id as $i => $item_id) {
            $pr_item = PurchaseRequestItem::with('cart_item.supply','purchase_request','bidding_item')->findOrFail($item_id);
            $pr_items_count++;

            $status = $request->status[$i];

            if($pr_item->status != $status) {
                $pr_item->status = $status;
                $pr_item->updated_by = $user->id;

                if($status == 'Decline') {
                    $pr_item->remarks = $request->item_remarks[$i];
                    $done++;

                    $requisition = $pr->items->first()->cart_item->cart->request;
                    $requisition -= $cart_item->unit_cost;
                    $requisition->save();

                    $cart_item = CartItem::findOrFail($pr_item->cart_item->id);
                    $cart_item->status = 'Decline';
                    $cart_item->remarks = $request->item_remarks[$i];
                    $cart_item->updated_by = $user->id;
                    $cart_item->save();
                }
                if($status == 'Bidding') {
                    $done++;

                    $bidding = Bidding::where('purchase_request_id',$pr->id)->first();
                    
                    if(!$bidding) {
                        $bid = new Bidding;
                        $bid->user_id = auth()->user()->id;
                        $bid->purchase_request_id = $pr->id;
                        $bid->save();

                        $bi = new BiddingItem;
                        $bi->bidding_id = $bid->id;
                        $bi->purchase_request_item_id = $pr_item->id;
                        $bi->save();

                    } else {
                        $bi = new BiddingItem;
                        $bi->bidding_id = $bidding->id;
                        $bi->purchase_request_item_id = $pr_item->id;
                        $bi->save();
                    }                                    
                }
                if($status == 'Approve') {
                    $done++;

                    // $po_exist = PurchaseOrder::where('qualification_id',$pr_item->purchase_request->qualification_id)->where('supplier_id',$pr_item->supplier_id)->where('is_active',1)->first();
                    
                    // if(!$po_exist) {
                    //     $po = new PurchaseOrder;
                    //     $po->user_id = auth()->user()->id;
                    //     $po->qualification_id = $pr_item->purchase_request->qualification_id;
                    //     $po->purchase_request_id = $pr_item->purchase_request_id;
                    //     $po->supplier_id = $pr_item->supplier_id;
                    //     $po->save();

                    //     $po_items = new PurchaseOrderItem;
                    //     $po_items->purchase_order_id = $po->id;
                    //     $po_items->purchase_request_item_id = $pr_item->id;
                    //     $po_items->save();

                    // } else {
                    //     $po_items = new PurchaseOrderItem;
                    //     $po_items->purchase_order_id = $po_exist->id;
                    //     $po_items->purchase_request_item_id = $pr_item->id;
                    //     $po_items->save();
                    // }        

                    // $cart_item = CartItem::findOrFail($pr_item->cart_item->id);
                    
                    // $requisition = $pr->items->first()->cart_item->cart->request;
                    // $requisition->overall_total += $cart_item->unit_cost;
                    // $requisition->save();
                }                
            }
            if($status == 'Receive') {
                $supply = $pr_item->cart_item->supply;
                $supply->in_stock = 1;
                $supply->save();

                $cart_item = $pr_item->cart_item;
                if($cart_item->status != 'In Stoc') {
                    $cart_item->status = 'In Stock';
                    $cart_item->save();
                }                
            }

            $pr_item->save();
        }

        if($done > 0) {
            $pr = PurchaseRequest::findOrFail($pr_item->purchase_request->id);
            $pr->is_active = 0;
            $pr->save();

            return redirect()->back()->with('success','Successfully closed this purchase request!');
        }

        return redirect()->back()->with('success','Successfully updated purchase request!');
    }

    public function destroy(PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function award(Request $request) 
    {
        $cart_item = CartItem::findOrFail($request->cart_item_id);
        $cart_item->unit_cost = $request->unit_cost;
        $cart_item->save();

        $pr_item = PurchaseRequestItem::findOrFail($request->pr_item_id);
        $pr_item->supplier_id = $request->supplier_id;
        $pr_item->status = 'Awarded';
        $pr_item->save();

        return redirect()->back()->with('success','Awarded successfully!');
    }

    public function award_index(Request $request)
    {
        $prs = PurchaseRequest::with('user','qualification','items')->latest()->get();
        return view('purchase-request.award_index',compact('request','prs'));
    }

    public function award_edit($id,Request $request)
    {
        $pr = PurchaseRequest::with('user','qualification','items.cart_item.supply.qualification')
                            ->withCount('completed')
                            ->findOrFail($id);

        $suppliers = Supplier::get();

        return view('purchase-request.award_edit',compact('pr','suppliers','request'));
    }

    public function award_update(Request $request)
    {
        foreach($request->cart_item_id as $i => $cart_item_id) {
            $cart_item = CartItem::findOrFail($cart_item_id);
            $cart_item->unit_cost = $request->unit_cost[$i];
            $cart_item->save();

            $pr_item = PurchaseRequestItem::findOrFail($request->pr_item_id[$i]);
            $pr_item->supplier = $request->supplier[$i];
            $pr_item->save();

            $po_exist = PurchaseOrder::where('qualification_id',$pr_item->purchase_request->qualification_id)->where('supplier',$pr_item->supplier)->where('is_active',1)->first();
            if(!$po_exist) {
                $po = new PurchaseOrder;
                $po->user_id = auth()->user()->id;
                $po->qualification_id = $pr_item->purchase_request->qualification_id;
                $po->purchase_request_id = $pr_item->purchase_request_id;
                $po->supplier = $pr_item->supplier;
                $po->save();

                $po_items = new PurchaseOrderItem;
                $po_items->purchase_order_id = $po->id;
                $po_items->purchase_request_item_id = $pr_item->id;
                $po_items->save();

            } else {
                $po_items = new PurchaseOrderItem;
                $po_items->purchase_order_id = $po_exist->id;
                $po_items->purchase_request_item_id = $pr_item->id;
                $po_items->save();
            }        
            
            $requisition = $pr_item->cart_item->cart->request;
            $requisition->overall_total += $cart_item->unit_cost;
            $requisition->save();
        }
        return redirect()->back()->with('success','Awarded successfully!');
    }
}
