<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseOrderExport;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $purchase_orders = PurchaseOrder::with('pr')->latest()->get();
        return view('purchase-order.index',compact('request','purchase_orders'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $po = PurchaseOrder::with('user','qualification','items.pr_item.cart_item.supply.qualification')
                            ->withCount('completed')
                            ->findOrFail($id);

        if($request->report) {
            $data = $po;
            return Excel::download(new PurchaseOrderExport($data), 'Purchase Order.xlsx');
        }
                            
        return view('purchase-order.edit',compact('po','request'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delivery_term = $request->delivery_term;
        $purchaseOrder->mode_of_procurement = $request->mode_of_procurement;
        $purchaseOrder->is_submitted = 1;
        $purchaseOrder->save();
        $done = 0;
        
        foreach($request->item_id as $i => $item_id) {
            $po_item = PurchaseOrderItem::find($item_id);
            $pr_item = PurchaseRequestItem::find($request->pr_item_id[$i]);
            $status = $request->status[$i];

            if($pr_item->status != 'In Stock') {
                if($status == 'Receive') {
                    $done++;
                    $po_item->status = 'Received';
                    $po_item->save();
    
                    $pr_item->status = 'In Stock';
                    $pr_item->save();

                    $unit_cost = $pr_item->cart_item->unit_cost;

                    $qualification = $purchaseOrder->qualification;
                    $qualification->remaining_budget -= $unit_cost;
                    $qualification->save();
                }
                if($status == 'Approve') {
                    $po_item->status = 'Approve';
                    $po_item->save();
                }
            }            
        }

        if($done == $purchaseOrder->items->count()) {
            $purchaseOrder->is_active = 0;
            $purchaseOrder->save();

            return redirect()->back()->with('success','Successfully closed this purchase request!');
        }

        return redirect()->back()->with('success','Successfully updated purchase order!');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
