@extends('layouts.app')
@extends('layouts.sidebar')
@extends('layouts.navbar')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Purchase Request Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Purchase Request Details</li>
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
                     </div>                      
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      @if ($message = Session::get('success'))
                          <div class="alert alert-success">
                              <p>{{ $message }}</p>
                          </div>
                      @endif
                    
                    <div class="row">
                        <?php if(isset($reqinfo) && !empty($reqinfo)){ 
                            $address = explode(',', $reqinfo['PurchaseOrder']['DeliveryAddress']);
                            // echo '<pre>';print_r($address);die;
                            ?>
                            <div class="col-md-12">
                                <h4><u> #Request Info</u></h4>
                                <div class="row">
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="row">
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

                            <div class="col-md-12">
                                <h4><u> #Vendor/Supplier Quotation</u></h4>
                                <div class="row">
                                    @hasrole('Vendor')
                                    @if (empty($reqinfo['PurchaseOrder']['SupplierId']))
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
                                    @else
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
                                                <td>{{ $reqinfo['PurchaseOrder']['VendorEstdTotalCost'] }}</td>
                                                <td>{{ $vendorinfo->name }}</td>
                                                <td>{{ $reqinfo['PurchaseOrder']['VendorQuotedate'] }}</td>
                                                <td>{{ $reqinfo['PurchaseOrder']['SupplierAddress'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                    @endhasrole
                                    @hasanyrole('Checker|User')
                                    @if (!empty($reqinfo['PurchaseOrder']['SupplierId']))
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
                                                <td>{{ $reqinfo['PurchaseOrder']['VendorEstdTotalCost'] }}</td>
                                                <td>{{ $vendorinfo->name }}</td>
                                                <td>{{ $reqinfo['PurchaseOrder']['VendorQuotedate'] }}</td>
                                                <td>{{ $reqinfo['PurchaseOrder']['SupplierAddress'] }}</td>
                                            </tr>
                                    </tbody>
                                    @else
                                    <div class="col-md-12 text-center"><strong style="color: red;">No Quotation Found</strong></div>
                                    @endif
                                    @endhasanyrole
                                </div>
                            </div>
                            <br><br><br>
                            <div class="col-md-12">
                                <h4><u> #Purchase Order Details</u></h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <table class="table">
                                            <thead></thead>
                                            <tbody>
                                              <tr>
                                                <th scope="row">PONo:</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['PONo'] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Request Date & Time:</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['PORequestedDate'] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Request By:</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['PORequestedBy'] }}</td>
                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <table class="table">
                                            <thead></thead>
                                            <tbody>
                                              <tr>
                                                <th scope="row">PO Status:</th>
                                                @if ($reqinfo['PurchaseOrder']['POStatus'] == 1)
                                                    <td style="color: rgb(182, 135, 7); font-weight: 600;">Ordered</td>
                                                @elseif($reqinfo['PurchaseOrder']['POStatus'] == 2)
                                                    <td style="color: green; font-weight: 600;">Approved</td>
                                                @endif
                                              </tr>
                                              <tr>
                                                <th scope="row">PO Approved By:</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['POApprovedBy'] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Approve Date:</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['POApprovedDate'] }}</td>
                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="text-center"><h4 style="color: red;">No Data Found</h4></div>
                        <?php } ?>
                    </div>
                  </div>
                  <!-- /.card-body -->
          </div>
          
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection 

<script>
    function calculateTotal(val){
        qty = parseFloat(document.getElementById("qty").value);
            if(isNaN(qty)){ qty = 0; }
        document.getElementById("total_cost").value = parseFloat(qty * val);
    }
</script>