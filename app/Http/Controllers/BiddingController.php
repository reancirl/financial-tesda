<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Supplier;
use App\Models\BiddingItem;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequestItem;
use App\Models\CartItem;

class BiddingController extends Controller
{
    public function index()
    {
        $biddings = Bidding::latest()->get();
        return view('bidding.index',compact('biddings'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $bidding = Bidding::findOrFail($request->id);
        $bidding->fill($request->except(['id']));
        $bidding->save();

        return redirect()->back()->with('success','Successfully added suppliers');
    }

    public function show(Bidding $bidding)
    {
        //
    }

    public function edit($id)
    {
        $bidding = Bidding::with('items.pr_item.cart_item.supply')->findOrFail($id);
        return view('bidding.edit',compact('bidding'));
    }

    public function update(Request $request, Bidding $bidding)
    {
        // return $request->all();
        $bidding->is_done = $request->is_done;
        $bidding->save();

        foreach ($request->item_id as $i => $item_id) {
            $item = BiddingItem::findOrFail($item_id);
            $item->price_one = $request->price_one[$i];
            $item->price_two = $request->price_two[$i];
            $item->price_three = $request->price_three[$i];
            $item->save();
            
            $price_one = $request->price_one[$i] ?? 999999;
            $price_two = $request->price_two[$i] ?? 999999;
            $price_three = $request->price_three[$i] ?? 999999;
            
            if($price_one < $price_two && $price_one < $price_three) {
                $supplier_id = $bidding->supplier_one_id;
                $unit_cost = $item->price_one;
            } elseif ($price_two < $price_one && $price_two < $price_three) {
                $supplier_id = $bidding->supplier_two_id;
                $unit_cost = $item->price_two;
            } else {
                $supplier_id = $bidding->supplier_three_id;
                $unit_cost = $item->price_three;
            }

            // $unit_cost = min($item->price_one ?? 99999,$item->price_two ?? 99999,$item->price_three ?? 99999);

            $item->winner_supplier_id = $supplier_id;
            $item->save();

            $pr_item = PurchaseRequestItem::where('purchase_request_id',$bidding->purchase_request_id)->where('id',$item->purchase_request_item_id)->first();
            $pr_item->cart_item->unit_cost = $unit_cost;
            $pr_item->cart_item->save();

            if($request->approve == 'true') {
                $po_exist = PurchaseOrder::where('qualification_id',$pr_item->purchase_request->qualification_id)->where('is_active',1)->where('supplier_id',$pr_item->bidding_item->winner_supplier_id)->first();
                
                if(!$po_exist) {
                    $po = new PurchaseOrder;
                    $po->user_id = auth()->user()->id;
                    $po->qualification_id = $pr_item->purchase_request->qualification_id;
                    $po->purchase_request_id = $pr_item->purchase_request_id;
                    $po->supplier_id = $pr_item->bidding_item->winner_supplier_id;
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

                $cart_item = CartItem::findOrFail($pr_item->cart_item->id);
                
                $requisition = $bidding->purchase_request->request;
                $requisition->overall_total += $cart_item->unit_cost;
                $requisition->save();

                $pr_item->status = 'Approve';
                $pr_item->save();

                $bidding->is_approved = 1;
                $bidding->save();
            }  
        }

        return redirect()->back()->with('success','Successfully updated bidding!');
    }

    public function destroy(Bidding $bidding)
    {
        //
    }

    public function addBidder($id) 
    {
        $suppliers = Supplier::latest()->get();
        return view('bidding._addBidders',compact('id','suppliers'));
    }
}
