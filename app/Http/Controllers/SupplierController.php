<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::get();
        return view('supplier.index',compact('supplier'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = new Supplier;
        $data->fill($request->all());
        $data->save();

        return redirect()->back()->with('success','Successfully created supplier');
    }

    public function show(Supplier $supplier)
    {
        //
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier._edit',compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->fill($request->all());
        $supplier->save();

        return redirect()->back()->with('success','Successfully edited supplier');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->back()->with('success','Successfully deleted supplier');
    }
}
