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
                                                <th scope="row">PRNo</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['PRNo'] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Request Date & Time</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['PRRequestDate'] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Request By</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['PRRequestedBy'] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Purpose</th>
                                                <td>{{ $reqinfo['PurchaseOrder']['PRPurpose'] }}</td>
                                              </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <table class="table">
                                            <tbody>
                                              <tr>
                                                <th scope="row">Address Line 1</th>
                                                <td>{{ $address[0] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Address Line 2</th>
                                                <td>{{ $address[1] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Contact Number</th>
                                                <td>{{ $address[2] }}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Request Status</th>
                                                @if ($reqinfo['PurchaseOrder']['PRStatus'] == 1)
                                                    <td style="color: red; font-weight: 600;">Pending Approval</td>
                                                @else
                                                    <td style="color: green; font-weight: 600;">Approved</td>
                                                @endif
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
                                                foreach ($productinfo as $value) {
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