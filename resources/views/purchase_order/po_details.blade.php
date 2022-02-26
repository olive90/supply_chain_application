@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.navbar')

<style>
    .checked {
      color: orange;
    }
    </style>

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Purchase Order Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item active">Purchase Order Details</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="card-title">Details</h3>
                                </div>
                                <div>
                                    <button class="btn btn-outline-info" onclick="printDiv()">Print</a>
                                </div>
                            </div>                      
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" id="printPO">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                        
                                <?php if(isset($reqinfo) && !empty($reqinfo)){ 
                                    $address = explode(',', $reqinfo['PurchaseOrder']['DeliveryAddress']);
                                    // echo '<pre>';print_r($address);die;
                                        if(!empty($reqinfo['PurchaseOrder']['DeliveredDate'])){
                                ?>
                                    <div class="row" style="background-color: grey; color: white; padding-top: 10px;padding-bottom: 10px; font-size: 15pt;">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <strong>Delivered</strong>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <strong>Date & Time: </strong>{{ $reqinfo['PurchaseOrder']['DeliveredDate'] }}
                                        </div>
                                    </div>
                                    <br>
                                    <?php } ?>
                                    <div class="row" style="margin-top: 15px;">
                                        <h4><u> #Request Info</u></h4>
                                        <div class="col-xs-12 col-sm-12 col-md-12 d-flex justify-content-between">
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">PRNo:</th>
                                                        <td>{{ $reqinfo['PurchaseOrder']['PRNo'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Request Date & Time:</th>
                                                        <td>{{ $reqinfo['PurchaseOrder']['PRRequestDate'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Request By:</th>
                                                        <td>{{ $reqinfo['PurchaseOrder']['PRRequestedBy'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Purpose:</th>
                                                        <td>{{ isset($reqinfo['PurchaseOrder']['PRPurpose'])?$reqinfo['PurchaseOrder']['PRPurpose']:'' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Approved By:</th>
                                                        <td>{{ $reqinfo['PurchaseOrder']['PRApprovedBy'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Special Ordering Instructions:</th>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Address Line 1:</th>
                                                        <td>{{ $address[0] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Address Line 2:</th>
                                                        <td>{{ $address[1] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Contact Number:</th>
                                                        <td>{{ $address[2] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Request Status:</th>
                                                        @if ($reqinfo['PurchaseOrder']['PRStatus'] == 1)
                                                            <td style="color: red; font-weight: 600;">Pending Approval</td>
                                                        @elseif($reqinfo['PurchaseOrder']['PRStatus'] == 2)
                                                            <td style="color: green; font-weight: 600;">Approved</td>
                                                        @elseif($reqinfo['PurchaseOrder']['PRStatus'] == 3)
                                                            <td style="color: red; font-weight: 600;">Cancelled</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Approve Date:</th>
                                                        <td>{{ $reqinfo['PurchaseOrder']['PRApprovedDate'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Shipping Instructions:</th>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h4><u> #Product/Item Details</u></h4>
                                            <table class="table table-bordered data-table">
                                                <thead>
                                                    <tr>
                                                        <th>SL#</th>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Details</th>
                                                        <th>Category</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    // echo '<pre>';print_r($allData);die;
                                                        $i=1;
                                                        $p_name = '';
                                                        foreach ($productinfo as $value) {
                                                            $p_name = $value['name'];
                                                    ?>
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $value['name'] }}</td>
                                                            <td>{{ $reqinfo['PurchaseOrder']['PREstdQuantity'] }}</td>
                                                            <td>{{ $value['details'] }}</td>
                                                            <td>{{ $value['category_name'] }}</td>
                                                        </tr>
                                                    <?php
                                                            }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h4><u> #Vendor/Supplier Quotation</u></h4>
                                        </div>
                                        @hasrole('Vendor')
                                        @if (empty($reqinfo['PurchaseOrder']['SupplierId']))
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="col-md-4">
                                                <form action="{{ route('pr.update', Request::segment(2)) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="pr_quote" value="pr_quote">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <strong>Product Name</strong>
                                                            <input type="text" name="p_name" class="form-control" value="{{ $p_name }}" readonly>
                                                        </div>
                                                    </div>
                
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <strong>Quantity</strong>
                                                            <input type="text" name="qty" id="qty" class="form-control" value="{{ $reqinfo['PurchaseOrder']['PREstdQuantity'] }}" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <strong>Per Unit Cost</strong>
                                                            <input type="text" name="unit_cost" class="form-control" onkeyup="calculateTotal(this.value)">
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <strong>Total Cost</strong>
                                                            <input type="text" name="total_cost" id="total_cost" class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4"></div>
                                        </div>
                                        @else
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <table class="table table-bordered data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Per Unit Cost</th>
                                                        <th>Total Cost</th>
                                                        <th>Quotation Submitted By</th>
                                                        <th>Quotation Submitted Date</th>
                                                        <th>Supplier Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $p_name }}</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['PREstdQuantity'] }}</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['VendorEstdCost'] }}</td>
                                                        <td><strong style="color: green;font-size: 15pt;">{{ $reqinfo['PurchaseOrder']['VendorEstdTotalCost'] }}</strong></td>
                                                        <td>{{ $vendorinfo->name }}</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['VendorQuotedate'] }}</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['SupplierAddress'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        @endhasrole
                                        @hasanyrole('Checker|User')
                                        @if(!empty($reqinfo['PurchaseOrder']['SupplierId']))
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <table class="table table-bordered data-table">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Per Unit Cost</th>
                                                        <th>Total Cost</th>
                                                        <th>Quotation Submitted By</th>
                                                        <th>Quotation Submitted Date</th>
                                                        <th>Supplier Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $p_name }}</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['PREstdQuantity'] }}</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['VendorEstdCost'] }}</td>
                                                        <td><strong style="color: green;font-size: 15pt;">{{ $reqinfo['PurchaseOrder']['VendorEstdTotalCost'] }}</strong></td>
                                                        <td>{{ $vendorinfo->name }} (<?=$rating[0]['rating']?> <span class="fa fa-star checked"></span>)</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['VendorQuotedate'] }}</td>
                                                        <td>{{ $reqinfo['PurchaseOrder']['SupplierAddress'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @else
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center"><strong style="color: red;">No Quotation Found</strong></div>
                                        @endif
                                        @endhasanyrole
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h4><u> #Purchase Order Details</u></h4>
                                            @if (!empty($reqinfo['PurchaseOrder']['POStatus']))
                                                <div class="col-xs-6 col-sm-6 col-md-6" style="float: left">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                            <th scope="row">PONo:</th>
                                                            <td>{{ $reqinfo['PurchaseOrder']['PONo'] }}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">Order Date & Time:</th>
                                                            <td>{{ $reqinfo['PurchaseOrder']['PORequestedDate'] }}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">Ordered By:</th>
                                                            <td>{{ $reqinfo['PurchaseOrder']['PORequestedBy'] }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
        
                                                <div class="col-xs-6 col-sm-6 col-md-6" style="float: left">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                            <th scope="row">PO Status:</th>
                                                            @if ($reqinfo['PurchaseOrder']['POStatus'] == 1)
                                                                <td style="color: rgb(182, 135, 7); font-weight: 600;">Ordered <span style="color: red;">(Pending Approval)</span></td>
                                                            @elseif($reqinfo['PurchaseOrder']['POStatus'] == 2)
                                                                <td style="color: green; font-weight: 600;">Approved</td>
                                                            @endif
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">PO Approved By:</th>
                                                            <td>{{ $reqinfo['PurchaseOrder']['POApprovedBy'] }}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">Approve Date & Time:</th>
                                                            <td>{{ $reqinfo['PurchaseOrder']['POApprovedDate'] }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                <div class="col-xs-12 col-sm-12 col-md-12 text-center"><strong style="color: red;">No order placed</strong></div>
                                                @endif
                                        </div>
                                    </div>
                                    <br><br><br>
                                    <?php if(!empty($reqinfo['PurchaseOrder']['DeliveredDate'])){ ?>
                                    <div class="row text-center" style="margin-top: 25px;padding-bottom: 10px;padding-top: 50px;">
                                        <div class="col-xs-4 col-sm-4 col-md-4">
                                            <strong><u>Customer Signature</u></strong>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4">
                                            <strong><u>Delivery Person Signature</u></strong>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4">
                                            <strong><u>Supplier Signature</u></strong>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                <?php }else{ ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center"><h4 style="color: red;">No Data Found</h4></div>
                                <?php } ?>
                                    
                            </div>
                        </div>
                        <!-- /.card-body -->
            
                    </div>
                </div>
                <!-- /.row -->
        <!-- /.container-fluid -->
        </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>

@endsection 

<script>
    function calculateTotal(val){
        qty = parseFloat(document.getElementById("qty").value);
            if(isNaN(qty)){ qty = 0; }
        document.getElementById("total_cost").value = parseFloat(qty * val);
    }

    function printDiv() {
        var divToPrint = document.getElementById('printPO');
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'table th, table td {' +
            'border:1px solid #000;' +
            'padding:1.0em;' +
            '}' +
            '</style>';
        htmlToPrint += divToPrint.outerHTML;
        newWin = window.open("");
        newWin.document.write(htmlToPrint);
        newWin.print();
        newWin.close();
    }
</script>