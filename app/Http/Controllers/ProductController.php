<?php

namespace App\Http\Controllers;

use App\Product;
use App\Vendor;
use App\Category;
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
        $products = Product::join('categories', 'categories.id', '=', 'products.category')
                            ->select('products.*','categories.category_name')
                            ->get();

        return view('products.index',['products' => $products]);
    }

    public function create()
    {
        $categories = Category::select('id', 'category_name')
                                ->where('active', 'Y')
                                ->orderBy('id', 'desc')
                                ->get();

        return view('products.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name',
            'unit_price' => 'required',
            'details' => 'required',
            'category' => 'required',
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
        $categories = Category::select('id', 'category_name')
                                ->where('active', 'Y')
                                ->orderBy('id', 'desc')
                                ->get();

        return view('products.edit',['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
            'unit_price' => 'required',
            'details' => 'required',
            'category' => 'required',
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
