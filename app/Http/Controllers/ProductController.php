<?php

namespace App\Http\Controllers;

use App\Product;
use App\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = Product::join('vendors', 'vendors.id', '=', 'products.vendor_id')
                            ->select('products.*','vendors.name as vendor_name')
                            ->get();
        return view('products.index',['products' => $products]);
    }

    public function create()
    {
        $vendors = Vendor::where('Active', 'Y')->get();
        return view('products.create', ['vendors' => $vendors]);
    }

    public function store(Request $request)
    {
        //return $request->all();
        $this->validate($request, [
            'name' => 'required|unique:products,name',
            'unit_price' => 'required',
            'details' => 'required',
            'vendor_id' => 'required',
        ]);
    
        Product::create($request->all());
    
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
            'unit_price' => 'required',
            'details' => 'required',
        ]);
    
        $product->update($request->all());
    
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}
