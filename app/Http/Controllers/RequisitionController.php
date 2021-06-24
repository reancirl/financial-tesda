<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\CartItem;
use App\Models\Requisition;
use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;

class RequisitionController extends Controller
{

    public function index(Request $request)
    {
        $quals = Qualification::get();

        $req = Requisition::with('user.qualification')->latest();

        if (auth()->user()->hasRole(['admin','department_head','supply_officer','finance_officer'])) {
            $req = $req;
        } else {
            $req = $req->where('user_id',auth()->user()->id);
        }

        if($request->search_qualification){
            $req = $req->join('users','users.id','requisitions.user_id')
                       ->join('qualifications','users.qualification_id','qualifications.id')
                       ->select('requisitions.*','users.qualification_id as qualification_id')
                       ->where('qualification_id',$request->search_qualification);
        }
        $req = $req->search($request)->get();

        return view('request.index',compact('req','quals','request'));
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
        $requisition = Requisition::with('cart.items.supply.qualification')->where('id',$id)->first();
        return view('request._show',compact('requisition'));
    }

    public function edit($id)
    {
        $requisition = Requisition::with('user','cart.items.supply.qualification','cart.completed')->where('id',$id)->first();
        return view('request.edit',compact('requisition'));
    }

    public function update(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id);
        $user = auth()->user();

        foreach($request->item_id as $i => $item_id) {
            $cart_item = CartItem::with('supply')->findOrFail($item_id);

            $status = $request->status[$i];

            if($cart_item->status != $status) {
                $cart_item->remarks = $request->item_remarks[$i];
                $cart_item->status = $status;
                $cart_item->updated_by = $user->id;

                if($status == 'On Process') {
                    $pr = PurchaseRequest::where('is_active',true)->where('qualification_id',$request->qualification_id)->first();

                    if(!$pr){
                        $pr = new PurchaseRequest;
                        $pr->user_id = $user->id;
                        $pr->requisition_id = $requisition->id;
                        $pr->qualification_id = $request->qualification_id;
                        $pr->is_active = 1;
                        $pr->save();                    
                    }

                    $pr_item = PurchaseRequestItem::where('purchase_request_id',$pr->id)->where('cart_item_id',$item_id)->first();

                    if(!$pr_item) {
                        $pr_item = new PurchaseRequestItem;
                        $pr_item->purchase_request_id = $pr->id;
                        $pr_item->cart_item_id = $item_id;
                        $pr_item->status = 'Pending';
                        $pr_item->updated_by = $user->id;
                        $pr_item->save();
                    }                                
                }
                if ($status == 'Decline') {
                    $cart_item->cart->request->overall_total -= $cart_item->unit_cost;
                    $cart_item->cart->request->save();
                    $cart_item->unit_cost = 0;
                }
                
                $cart_item->save();
            }
        }

        return redirect()->back()->with('success','Successfully updated request items!');
    }

    public function destroy(Requisition $requisition)
    {
        //
    }
}
