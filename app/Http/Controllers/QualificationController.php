<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use Illuminate\Http\Request;


class QualificationController extends Controller
{
    public function index(Request $request)
    {
        $quals = Qualification::latest();
        $quals = $quals->search($request)->paginate(50);        
        return view('qualification.index',compact('request','quals'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:qualifications',
            'remaining_budget' => 'required'
        ]);

        Qualification::create($validatedData);
        return redirect()->back()->with('success','Successfully created qualification');
    }

    public function show(Qualification $qualification)
    {
        //
    }

    public function edit(Qualification $qualification)
    {
        return view('qualification._modal',compact('qualification'));
    }

    public function update(Request $request, Qualification $qualification)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'remaining_budget' => 'required'
        ]);

        $qualification = $qualification->update($validatedData);
        return redirect()->back()->with('success','Successfully updated qualification');
    }

    public function destroy(Qualification $qualification)
    {
        $qualification->delete();
        return redirect()->back()->with('success','Successfully deleted qualification');        
    }
}
