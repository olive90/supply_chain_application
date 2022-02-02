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
use Illuminate\Support\Facades\Http;

class PurchaseRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pr-list|pr-create|pr-edit|pr-delete', ['only' => ['index','show']]);
        $this->middleware('permission:pr-create', ['only' => ['create','store']]);
        $this->middleware('permission:pr-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pr-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        //return 'hi';
        // $response = Http::post('localhost:3000/queryblock', [
        //     'key' => '1'
        // ]);
        // Http::fake();
        $data = array();
        $response = Http::get('localhost:3000/getblocks');
        $data = $response->json();
        
        $allData = $data['AllData'];
        for($i=0; $i<count($allData); $i++){
            if($allData[$i]['Key']=='PRId' || $allData[$i]['Key']=='test'){
                unset($allData[$i]);
            }
            $allData = array_values($allData);
        }
        
        return view('purchase_request.index', ['allData' => $allData]);
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
            'purpose' => 'required',
        ]);

        $pr_id = Str::random(10);
        $pr_no = rand(99999999, 10000000);
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

        $response = Http::post('localhost:3000/writews', [
            'Id' => $pr_id,
            "DeliveryDate" => "",
            "EstimatedAmount" => "",
            "EstimatedCost" => "",
            "EstimatedTotalCost" => "",
            "ItemId" => "",
            'OrderDate' => "",
            "OrderedItemCost" => "",
            "OrderedQuantity" => "",
            "OrderedTotalCost" => "",
            "POApprovedBy" => "",
            "POApprovedDate" => "",
            "PONo" => "",
            "PORequestedBy" => "",
            "PORequestedDate" => "",
            "POStatus" => "",
            "PRApprovedBy" => "",
            "PRApprovedDate" => "",
            "PRNo" => $pr_no,
            "PRPurpose" => $request->purpose,
            "PRRequestDate" => date('Y-m-d H:i:s'),
            "PRRequestedBy" => $request->user()->id,
            "PRStatus" => "1",                            //initial request
            "SupplierAddress" => $request->address1 . '#' . $request->address2,
            "SupplierId" => $request->phone
        ]);

        if($response){
            return redirect()->route('pr.index')
                            ->with('success','Purchase request submited successfully.');
        }else{
            return redirect()->route('pr.index')
                            ->with('error','Something went wrong. Please try again later.');
        }
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
