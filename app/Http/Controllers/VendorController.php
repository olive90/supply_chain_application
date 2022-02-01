<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;
use App\Category;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::join('categories', 'categories.id', '=', 'vendors.category')
                            ->select('vendors.*', 'categories.category_name')
                            ->get();

        return view('vendors.index',['vendors' => $vendors]);
    }

    public function create()
    {
        $categories = Category::select('id', 'category_name')
                                ->where('active', 'Y')
                                ->orderBy('id', 'desc')
                                ->get();

        return view('vendors.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:vendors,name',
            'address' => 'required',
            'phone_number' => 'required',
            'category' => 'required',
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
        $categories = Category::select('id', 'category_name')
                                ->where('active', 'Y')
                                ->orderBy('id', 'desc')
                                ->get();

        return view('vendors.edit',['vendor' => $vendor, 'categories' => $categories]);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'category' => 'required',
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
