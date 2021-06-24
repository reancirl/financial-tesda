<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;
use App\Models\Qualification;

class SupplyController extends Controller
{
    public function index(Request $request)
    {
        $supplies = Supply::latest();
        $quals = Qualification::get();

        if ($request) {
            $supplies = $supplies->search($request);
        }

        $supplies = $supplies->paginate(50);
        return view('supply.index',compact('supplies','request','quals'));
    }

    public function create()
    {
        $quals = Qualification::get();
        return view('supply.create',compact('quals'));
    }

    public function storeBulk(Request $request)
    {
        foreach($request->name as $i => $name) {
            $new = new Supply;
            $new->name = $request->name[$i];
            $new->code = $request->code[$i];
            $new->quantity = $request->quantity[$i];
            $new->unit = $request->unit[$i];
            $new->qualification_id = $request->qualification_id;
            $new->save();
        }

        return redirect('/supply')->with('success','Successfully created supplies');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:supplies',
            'quantity' => '',
            'unit' => 'required',
            'qualification_id' => ''
        ]);

        Supply::create($validatedData);
        return redirect()->back()->with('success','Successfully created supply');
    }

    public function show(Supply $supply)
    {
        
    }

    public function edit(Supply $supply)
    {
        $quals = Qualification::get();
        return view('supply._modal',compact('supply','quals'));
    }

    public function update(Request $request, Supply $supply)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'quantity' => '',
            'unit' => 'required',
            'qualification_id' => ''
        ]);

        $supply->update($validatedData);
        return redirect()->back()->with('success','Successfully updated supply');
    }

    public function destroy(Supply $supply)
    {
        $supply->delete();
        return redirect()->back()->with('success','Successfully deleted supply');
    }
}
