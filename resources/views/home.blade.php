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
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
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
                      <h3 class="card-title">All Purchase Requests</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php if(isset($allData) && !empty($allData)){ ?>
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>PONo</th>
                            <th>Request Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Supplier</th>
                            <th width="100px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            //echo '<pre>';print_r($allData);die;
                                $i=1;
                                foreach ($allData as $value) {
                            ?>
                                <tr>
                                    {{-- <td>{{ $i++ }}</td> --}}
                                    <td>{{ $value['PONo'] }}</td>
                                    <td>{{ $value['PRRequestDate'] }}</td>
                                    <td>{{ $value['DeliveryDate'] }}</td>
                                    <td>{{ $value['PRStatus'] }}</td>
                                    <td>{{ $value['SupplierId'] }}</td>
                                    {{-- <td>{{ $value['EstimatedAmount'] }}</td>
                                    <td>{{ $value['EstimatedCost'] }}</td>
                                    <td>{{ $value['EstimatedTotalCost'] }}</td>
                                    <td>{{ $value['ItemId'] }}</td>
                                    <td>{{ $value['OrderDate'] }}</td>
                                    <td>{{ $value['OrderedItemCost'] }}</td>
                                    <td>{{ $value['OrderedQuantity'] }}</td>
                                    <td>{{ $value['OrderedTotalCost'] }}</td>
                                    <td>{{ $value['POApprovedBy'] }}</td>
                                    <td>{{ $value['POApprovedDate'] }}</td>
                                    
                                    <td>{{ $value['PORequestedBy'] }}</td>
                                    <td>{{ $value['PORequestedDate'] }}</td>
                                    <td>{{ $value['POStatus'] }}</td>
                                    <td>{{ $value['PRApprovedBy'] }}</td>
                                    <td>{{ $value['PRApprovedDate'] }}</td>
                                    <td>{{ $value['PRNo'] }}</td>
                                    <td>{{ $value['PRPurpose'] }}</td>
                                    
                                    <td>{{ $value['PRRequestedBy'] }}</td>
                                    
                                    <td>{{ $value['SupplierAddress'] }}</td>
                                     --}}
                                    <td></td>
                                </tr>
                            <?php
                                    
                                }
                            ?>
                        </tbody>
                      </table>
                      <?php }else{ ?>
                        <h4 class="text-center" style="color: red;">No Data Found</h4>
                      <?php } ?>
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


