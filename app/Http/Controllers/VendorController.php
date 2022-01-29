<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(5);
        return view('vendors.index',['vendors' => $vendors]);
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:vendors,name',
            'address' => 'required',
            'phone_number' => 'required',
        ]);
    
        Vendor::create($request->all());
    
        return redirect()->route('vendors.index')
                        ->with('success','Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        //
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit',compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
        ]);
    
        $vendor->update($request->all());
    
        return redirect()->route('vendors.index')
                        ->with('success','Vendor updated successfully');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
    
        return redirect()->route('vendors.index')
                        ->with('success','Vendor deleted successfully');
    }
}
