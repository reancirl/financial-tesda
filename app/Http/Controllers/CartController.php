<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Supply;
use App\Models\CartItem;
use App\Models\Requisition;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //check if user have a cart with a status of not checkout
        $cart = Cart::active(auth()->user()->id)->first();

        //if cart does not exist create a new cart
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $request->user_id;
            $cart->is_checkout = 0;
            $cart->save();
        } 
        
        //find the product
        $supply = Supply::findOrFail($request->supply_id);

        //check if item is already in the cart
        $item = CartItem::exist($supply->id,$cart->id)->first();

        //if item is already in the cart dont create a new row instead add quantity
        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else { //else add a new row for the added item
            $item = new CartItem;
            $item->cart_id = $cart->id;
            $item->supply_id = $request->supply_id;
            $item->quantity = 1;
            $item->save();
        }

        
        $items = CartItem::where('cart_id',$cart->id)->count() ?? 0;

        return $items;
    }

    public function show(Cart $cart)
    {
        //
    }

    public function edit($id)
    {
        $cart = Cart::with('items.supply')->active($id)->first();
        if (!$cart) {
            return redirect()->back()->with('error','Cart Does not have any item/s');
        }
        return view('cart.edit',compact('cart'));
    }

    public function update(Request $request,$id)
    {
        if ($request->overall_total) {
            $cart = Cart::findOrFail($id);

            if ($request->overall_total) {
                $cart->is_checkout = 1;
                $cart->save();

                $req = new Requisition;
                $req->user_id = auth()->user()->id;
                $req->cart_id = $cart->id;
                $req->overall_total = $request->overall_total;
                $req->save();

                foreach ($request->item as $i => $item) {
                    $data = CartItem::findOrFail($item);
                    $data->quantity = $request->quantity[$i];
                    $data->save();
                }

                return redirect()->route('request.index')->with('success','Checkout Successfully!');
            }           
        } else {
            $item = CartItem::findOrFail($id);

            $supply = Supply::findOrFail($item->supply_id);

            if ($request->minus) {
                $item->quantity -= 1;
                $item->save();
            }
            if ($request->add) {
                $item->quantity += 1;
                $item->save();
            }

            return 'success';
        }            
    }

    public function destroy($id)
    {
        $item = CartItem::findOrFail($id);
        $cart_id = $item->cart_id;
        $item->delete();
        $items = CartItem::where('cart_id',$cart_id)->count() ?? 0;
        return $items;
    }
}
