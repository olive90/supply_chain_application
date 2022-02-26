<?php

namespace App\Http\Controllers;

use App\PurchaseOrder;
use Illuminate\Http\Request;
use App\Vendor;
use App\Product;
use App\Category;
use App\Remarks;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\PurchaseRequestMaster;
use App\PurchaseRequestDetails;
use Illuminate\Support\Facades\Http;
use DB;

class PurchaseOrderController extends Controller
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
        $vendorData = array();
        $prRequest = array();
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

        $chkrole = $request->user()->hasRole('Vendor'); 
        if($chkrole)
        {
            $pr_id = PurchaseRequestMaster::select('puchase_request_master.pr_id')
                                            ->join('vendors as v','v.category','=','puchase_request_master.category')
                                            ->where('v.userid', $request->user()->id)
                                            ->get();

            foreach($allData as $prDataKey => $prData){
                foreach($pr_id as $pridKey => $prid){
                    if($prData['Key'] == $prid['pr_id'] && $prData['Record']['PRStatus'] == 2){
                        $vendorData[$prDataKey] = $prData;
                    }
                }
            }

            $prRequest = $vendorData;
        }
        else
        {
            $prRequest =$allData;
        }


        $remarks = Remarks::join('puchase_request_master', 'puchase_request_master.pr_id', '=', 'remarks.pr_id')
                            ->join('users', 'users.id', '=', 'remarks.user_id')
                            ->orderBy('puchase_request_master.pr_id', 'asc')
                            ->get()
                            ->toArray();
        
        
        // echo '<pre>';print_r($remarks);die;
        // echo '<pre>';print_r($prRequest);die;
        
        return view('purchase_order.index', ['allData' => $prRequest, 'remarks' => $remarks]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        
        $vendorInfo = Vendor::where('userid', $data['PurchaseOrder']['SupplierId'])->first();

        $rating = Remarks::select(DB::raw('round(AVG(remarks.rating),1) as rating'))
                            ->join('puchase_request_master', 'puchase_request_master.pr_id', '=', 'remarks.pr_id')
                            ->join('vendors', 'vendors.category', '=', 'puchase_request_master.category')
                            ->where('vendors.userid', $data['PurchaseOrder']['SupplierId'])
                            ->get();

        // echo '<pre>';print_r($rating[0]['rating']);die;
        
        return view('purchase_order.po_details', ['reqinfo' => $data, 'productinfo' => $productInfo, 'vendorinfo' => $vendorInfo, 'rating' => $rating]);   
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    public function update(Request $request, $pr_key)
    {
        $message = '';
        $status = '';
        if($request->po_delivered){
            $key = base64_decode($pr_key);
            $vendor = Vendor::where('userid', $request->user()->id)->first();
            // return $vendor->address;
            $prInfo = Http::post('localhost:3000/queryblock', ["key"=>$key]);

            $po_no = 'PO' . rand(9999999999, 1000000000);

            $response = Http::post('localhost:3000/writews', [
                "user"                          => $request->user()->name,
                "Id"                            => $key,
                "DeliveryDate"                  => $prInfo['PurchaseOrder']['DeliveryDate'],
                "DeliveredDate"                 => date('Y-m-d H:i:s'),
                "DeliveryAddress"               => $prInfo['PurchaseOrder']['DeliveryAddress'],
                "ItemId"                        => $prInfo['PurchaseOrder']['ItemId'],
                "VendorEstdCost"                => $prInfo['PurchaseOrder']['VendorEstdCost'],
                "PREstdQuantity"                => $prInfo['PurchaseOrder']['PREstdQuantity'],
                "VendorEstdTotalCost"           => $prInfo['PurchaseOrder']['VendorEstdTotalCost'],
                "VendorQuotedate"               => $prInfo['PurchaseOrder']['VendorQuotedate'],
                'OrderDate'                     => $prInfo['PurchaseOrder']['OrderDate'],
                "OrderedItemCost"               => $prInfo['PurchaseOrder']['OrderedItemCost'],
                "OrderedQuantity"               => $prInfo['PurchaseOrder']['OrderedQuantity'],
                "OrderedTotalCost"              => $prInfo['PurchaseOrder']['OrderedTotalCost'],
                "POApprovedBy"                  => $prInfo['PurchaseOrder']['POApprovedBy'],
                "POApprovedDate"                => $prInfo['PurchaseOrder']['POApprovedDate'],
                "PONo"                          => $prInfo['PurchaseOrder']['PONo'],
                "PORequestedBy"                 => $prInfo['PurchaseOrder']['PORequestedBy'],
                "PORequestedDate"               => $prInfo['PurchaseOrder']['PORequestedDate'],
                "POStatus"                      => $prInfo['PurchaseOrder']['POStatus'],                        //PO submitted
                "PRApprovedBy"                  => $prInfo['PurchaseOrder']['PRApprovedBy'],
                "PRApprovedDate"                => $prInfo['PurchaseOrder']['PRApprovedDate'],
                "PRNo"                          => $prInfo['PurchaseOrder']['PRNo'],
                "PRPurpose"                     => isset($prInfo['PurchaseOrder']['PRPurpose'])?$prInfo['PurchaseOrder']['PRPurpose']:'',
                "PRRequestDate"                 => $prInfo['PurchaseOrder']['PRRequestDate'],
                "PRRequestedBy"                 => $prInfo['PurchaseOrder']['PRRequestedBy'],
                "PRStatus"                      => $prInfo['PurchaseOrder']['PRStatus'],                        //pr approved
                "SupplierAddress"               => $prInfo['PurchaseOrder']['SupplierAddress'],
                "SupplierId"                    => $prInfo['PurchaseOrder']['SupplierId'],
                "GenStatus"                     => "7"                                                          //po delivered
            ]);
    
            $resp = json_decode($response, true);
            $resultResponse = empty($resp) ? '001' : $resp;

            if($resultResponse != '001'){
                $message = 'Purchase Order Delivered successfully.';
                $status = 'success';
            }else{
                $message = 'Permission denied. Please contact to your administrator.';
                $status = 'error';
            }
        }
        else
        {
            $message = 'Permission denied. Please contact to your administrator.';
            $status = 'error';

            return redirect()->route('/home')->with($status, $message);
        }

        return redirect()->route('purchase-order.index')->with($status, $message);
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
