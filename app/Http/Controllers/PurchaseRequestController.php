<?php

namespace App\Http\Controllers;

use App\PurchaseRequest;
use Illuminate\Http\Request;
use App\Vendor;
use App\Product;
use App\Category;

class PurchaseRequestController extends Controller
{
    
    public function index()
    {
        return view('purchase_request.index');
    }

    public function create()
    {
        $categories = Category::where('Active', 'Y')->get();
        return view('purchase_request.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function edit(PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function update(Request $request, PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function destroy(PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function getProduct(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $product = Product::select('id','name')
                            ->where('category_id', $categoryId)
                            ->where('active', 'Y')
                            ->get();

        return json_encode($product);
    }

    public function getProductUnitPrice(Request $request)
    {
        $productId = $request->input('productId');
        $unitPrice = Product::select('unit_price')
                            ->where('id', $productId)
                            ->where('active', 'Y')
                            ->get();
            
        return json_encode($unitPrice);
    }
}
