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

        for($i=0; $i<count($allData); $i++){
            $a  = array_search('BlockFor', $allData[$i]['Record']);
            if($a == true){
                unset($allData[$i]);
            }
            $allData = array_values($allData);
        }

        for($i=0; $i<count($allData); $i++){
            $b  = array_search('quotation', $allData[$i]['Record']);
            if($b == true){
                unset($allData[$i]);
            }
            $allData = array_values($allData);
        }

        // echo '<pre>';print_r($allData);die;
        
        return view('purchase_request.index', ['allData' => $allData]);
    }

    public function create()
    {
        $categories = Category::where('active', 'Y')->get();
        return view('purchase_request.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required',
            'expected_delivery_date' => 'required',
            'address1' => 'required',
            'phone' => 'required',
            'purpose' => 'required',
            'product' => 'required',
            'qty' => 'required',
        ]);

        $pr_id = round(microtime(true) * 1000);
        $pr_no = 'PR' . rand(9999999999, 1000000000);

        $response = Http::post('localhost:3000/writews', [
            "user" => $request->user()->name,
            "Id" => $pr_id,
            "DeliveryDate" => $request->expected_delivery_date,
            "DeliveredDate" => "",
            "DeliveryAddress" => $request->address1 . "," . $request->address2 . "," . $request->phone,
            "ItemId" => $request->product,
            "VendorEstdCost" => "",
            "PREstdQuantity" => $request->qty,
            "VendorEstdTotalCost" => "",
            "VendorQuotedate" => "",
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
            "PRRequestedBy" => $request->user()->name,
            "PRStatus" => "1",                            //initial request
            "SupplierAddress" => "",
            "SupplierId" => "",
            "GenStatus" => "1"
        ]);

        $resp = json_decode($response, true);
        $resultResponse = empty($resp) ? '001' : $resp;

        if($resultResponse != '001'){

            $prMaster = new PurchaseRequestMaster();
            $prMaster->pr_id = $pr_id;
            $prMaster->category = $request->category;
            $prMaster->special_ordering_instructions = $request->ordering_instructions;
            $prMaster->shipping_instructions = $request->shipping_instructions;
            $prMaster->request_by = $request->user()->id;
            $prMaster->status = 1;
            $prMaster->save();
            
            return redirect()->route('pr.index')
                            ->with('success','Purchase request submited successfully.');
        }else{
            return redirect()->route('pr.index')
                            ->with('error','Something went wrong. Please try again later.');
        }
    }

    public function show($pr_key)
    {
        $key = base64_decode($pr_key);
        $data = array();
        $response = Http::post('localhost:3000/queryblock', ["key"=>$key]);
        $data = $response->json();

        $productInfo = Product::join('categories', 'categories.id', '=', 'products.category')
                                ->where('products.id', $data['PurchaseOrder']['ItemId'])
                                ->get();

        // echo '<pre>';print_r($data);die;
        
        return view('purchase_request.pr_details', ['reqinfo' => $data, 'productinfo' => $productInfo]);   
    }

    public function edit(PurchaseRequest $purchaseRequest)
    {
        //
    }

    public function update(Request $request, $pr_key)
    {
        $message = '';
        $status = '';
        if($request->pr_approve){
            $key = base64_decode($pr_key);

            $prInfo = Http::post('localhost:3000/queryblock', ["key"=>$key]);

            $response = Http::post('localhost:3000/writews', [
                "user" => $request->user()->name,
                "Id" => $key,
                "DeliveryDate" => $prInfo['PurchaseOrder']['DeliveryDate'],
                "DeliveredDate" => "",
                "DeliveryAddress" => $prInfo['PurchaseOrder']['DeliveryAddress'],
                "ItemId" => $prInfo['PurchaseOrder']['ItemId'],
                "VendorEstdCost" => "",
                "PREstdQuantity" => $prInfo['PurchaseOrder']['PREstdQuantity'],
                "VendorEstdTotalCost" => "",
                "VendorQuotedate" => "",
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
                "PRApprovedBy" => $request->user()->name,
                "PRApprovedDate" => date('Y-m-d H:i:s'),
                "PRNo" => $prInfo['PurchaseOrder']['PRNo'],
                "PRPurpose" => $prInfo['PurchaseOrder']['PRPurpose'],
                "PRRequestDate" => $prInfo['PurchaseOrder']['PRRequestDate'],
                "PRRequestedBy" => $prInfo['PurchaseOrder']['PRRequestedBy'],
                "PRStatus" => "2",                            //pr approved
                "SupplierAddress" => "",
                "SupplierId" => "",
                "GenStatus" => "2"      //approval
            ]);
    
            $resp = json_decode($response, true);
            $resultResponse = empty($resp) ? '001' : $resp;

            if($resultResponse != '001'){
                $message = 'Purchase request approved successfully.';
                $status = 'success';
            }else{
                $message = 'Something went wrong. Please try again later.';
                $status = 'error';
            }

            return redirect()->route('pr.index')->with($status, $message);
        }
        
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
