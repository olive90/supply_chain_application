<?php

namespace App\Http\Controllers;

use App\PurchaseRequest;
use Illuminate\Http\Request;
use App\Vendor;
use App\Product;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\PurchaseRequestMaster;
use App\PurchaseRequestDetails;

class PurchaseRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pr-list|pr-create|pr-edit|pr-delete', ['only' => ['index','show']]);
        $this->middleware('permission:pr-create', ['only' => ['create','store']]);
        $this->middleware('permission:pr-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pr-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        return view('purchase_request.index');
    }

    public function create()
    {
        $categories = Category::where('active', 'Y')->get();
        return view('purchase_request.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        //return $request->all();
        $this->validate($request, [
            'category' => 'required',
            'expected_delivery_date' => 'required',
            'address1' => 'required',
            'phone' => 'required',
        ]);

        $pr_id = Str::random(10);
        $prMaster = new PurchaseRequestMaster();
        $prMaster->pr_id = $pr_id;
        $prMaster->category = $request->category;
        $prMaster->special_ordering_instructions = $request->ordering_instructions;
        $prMaster->shipping_instructions = $request->shipping_instructions;
        $prMaster->request_by = $request->user()->id;
        $prMaster->status = 1;
        $prMaster->save();

        $prDetails = new PurchaseRequestDetails();

        if(count($request->product)>0){
            $prepareData = array();
            foreach($request->product as $key => $productid){
                foreach($request->qty as $q => $qtyid){
                    $prepareData[$q]['pr_id'] = $pr_id;
                    $prepareData[$q]['product'] = $productid;
                    $prepareData[$q]['qty'] = $qtyid;
                }
            }
            $prDetails->insert($prepareData);
        }
    
        return redirect()->route('pr.index')
                        ->with('success','Purchase request submited successfully.');
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
                            ->where('category', $categoryId)
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
