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
        <h1 class="m-0">Purchase Order</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Purchase Order</li>
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
                              <h3 class="card-title">Purchase Order Summary</h3>
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
                      @if ($message = Session::get('error'))
                          <div class="alert alert-danger">
                              <p>{{ $message }}</p>
                          </div>
                      @endif
                    <div class="row table-responsive">
                        <?php if(isset($allData) && !empty($allData)){ ?>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    @hasrole('Vendor')
                                    <th>Action</th>
                                    @endhasrole
                                    @hasanyrole('Checker|User')
                                    <th>Action</th>
                                    @endhasanyrole
                                    @hasanyrole('Checker|User')
                                    <th>Purchase Order Status</th>
                                    @endhasanyrole
                                    @hasrole('Checker')
                                    <th>Approval</th>
                                    @endhasrole
                                    <th>SL#</th>
                                    <th>PRNo</th>
                                    <th>Purpose</th>
                                    <th>Requested By</th>
                                    <th>Request Date & Time</th>
                                    <th>Expected Delivery Date</th>
                                    <th>PR Status</th>
                                    <th>Approved By</th>
                                    <th>Supplier Quotation Status</th>
                                    <th>Delivery Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // echo '<pre>';print_r($allData);die;
                                    $i=1;
                                    foreach ($allData as $dKey => $value) {
                                        $pr_key = base64_encode($value['Key']);
                                        if(!empty($value['Record']['POStatus']) && $value['Record']['POStatus'] == 2){
                                ?>
                                    <tr>
                                        @hasrole('Vendor')
                                            <td>
                                                <form action="{{ route('purchase-order.update',$pr_key) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                <?php 
                                                    if(($value['Record']['POStatus'] == 2 && $value['Record']['PRStatus'] != 3) && $value['Record']['GenStatus'] == 6){
                                                ?>
                                                    <p><button type="submit" name="po_delivered" class="btn btn-outline-primary">Delivered</button></p>
                                                    <input type="hidden" name="po_delivered" value="po_delivered">
                                                <?php } ?>
                                                </form>
                                            </td>
                                        @endhasrole
                                        @hasanyrole('Checker|User')
                                        <td>
                                            <form action="{{ route('pr.destroy',$pr_key) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <?php 
                                                    if($value['Record']['POStatus'] != 2 && $value['Record']['PRStatus'] != 3){
                                                ?>
                                                    <p><button type="submit" name="pr_cancel" class="btn btn-outline-danger">Cancel</button></p>
                                                    <input type="hidden" name="pr_cancel" value="pr_cancel">
                                                <?php } ?>
                                            </form>
                                            <?php 
                                                if(isset($remarks) && !empty($remarks)){ 
                                                    // echo '<pre>';print_r($remarks);die;
                                                foreach ($remarks as $rKey => $remark) {
                                                    
                                                if($remark['pr_id'][$dKey] != $value['Key'][$dKey]){
                                                    // echo $value['Key'].'/'.$remark['pr_id'];
                                            ?>
                                            <form action="{{ route('remarks.create') }}" method="POST" target="_blank">
                                                @csrf
                                                @method('GET')
                                                <?php 
                                                    if($value['Record']['GenStatus'] == 7 && $value['Record']['PRStatus'] != 3){
                                                ?>
                                                    <p><button type="submit" name="pr_key" class="btn btn-outline-primary" target="_blank">Remarks</button></p>
                                                    <input type="hidden" name="pr_key" value="{{ $pr_key }}">
                                                <?php } ?>
                                            </form>
                                            <?php }
                                                } 
                                            }else {
                                            ?>
                                            <form action="{{ route('remarks.create') }}" method="POST" target="_blank">
                                                @csrf
                                                @method('GET')
                                                <?php 
                                                    if($value['Record']['GenStatus'] == 7 && $value['Record']['PRStatus'] != 3){
                                                ?>
                                                    <p><button type="submit" name="pr_key" class="btn btn-outline-primary" target="_blank">Remarks</button></p>
                                                    <input type="hidden" name="pr_key" value="{{ $pr_key }}">
                                                <?php } ?>
                                            </form>
                                            <?php } ?>
                                        </td>
                                        @endhasanyrole
                                        @hasanyrole('Checker|User')
                                        <td>
                                            <form action="{{ route('pr.update',$pr_key) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <?php 
                                                    if($value['Record']['GenStatus'] == 4){
                                                ?>
                                                    <button type="submit" name="po_submit" class="btn btn-outline-primary">Submit PO</button>
                                                    <input type="hidden" name="po_submit" value="po_submit">
                                                <?php }else if($value['Record']['POStatus'] == 1){ ?>
                                                    <p><strong style="color: rgb(21, 218, 21); font-weight: 600;">Submitted</strong></p>
                                                    <p><strong style="color: rgb(255, 102, 0); font-weight: 600;">Pending Approval</strong></p>
                                                <?php }else if($value['Record']['POStatus'] == 2){ ?>
                                                    <strong style="color: rgb(21, 218, 21); font-weight: 600;">Approved</strong>
                                                    <?php } ?>
                                            </form>
                                        </td>
                                        @endhasanyrole
                                        @hasrole('Checker')
                                        <td>
                                            <form action="{{ route('pr.update',$pr_key) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <?php if($value['Record']['PRApprovedBy'] == '' && $value['Record']['PRStatus'] != 3){ ?>
                                                    <button type="submit" name="pr_approve" class="btn btn-outline-primary">Approve</button>
                                                    <input type="hidden" name="pr_approve" value="pr_approve">
                                                <?php } ?>
                                                <?php 
                                                    if($value['Record']['POStatus'] == 1 && $value['Record']['PRStatus'] != 3){
                                                ?>
                                                    <p><button type="submit" name="po_approve" class="btn btn-outline-primary">Approve PO</button></p>
                                                    <input type="hidden" name="po_approve" value="po_approve">
                                                <?php } ?>
                                            </form>
                                        </td>
                                        @endhasrole
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <a href="{{ route('purchase-order.show', $pr_key) }}" target="_blank">
                                                {{ $value['Record']['PRNo'] }}
                                            </a>
                                        </td>
                                        <td>{{ isset($value['Record']['PRPurpose'])?$value['Record']['PRPurpose']:'' }}</td>
                                        <td>{{ $value['Record']['PRRequestedBy'] }}</td>
                                        <td>{{ $value['Record']['PRRequestDate'] }}</td>
                                        <td>{{ $value['Record']['DeliveryDate'] }}</td>
                                        @if ($value['Record']['PRStatus'] == 1)
                                            <td style="color: red; font-weight: 600;">Pending Approval</td>
                                        @elseif($value['Record']['PRStatus'] == 2)
                                            <td style="color: green; font-weight: 600;">Approved</td>
                                        @elseif($value['Record']['PRStatus'] == 3)
                                            <td style="color: red; font-weight: 600;">Cancelled</td>
                                        @endif
                                        <td>
                                            @if ($value['Record']['PRApprovedBy'] != '')
                                                <p><strong>{{ $value['Record']['PRApprovedBy'] }}</strong></p>
                                                <p>Date: {{ $value['Record']['PRApprovedDate'] }}</p>
                                            @endif
                                        </td>
                                        @if (empty($value['Record']['VendorEstdCost']))
                                            <td style="color: rgb(255, 102, 0); font-weight: 600;">No quotation</td>
                                            @else
                                            <td style="color: rgb(21, 218, 21); font-weight: 600;">Quotation Submitted</td>
                                        @endif
                                        <td>
                                            @if(!empty($value['Record']['VendorEstdCost']))
                                            <strong style="color: rgb(21, 218, 21); font-weight: 600;">Delivered</strong>
                                            @else
                                            <strong style="color: rgb(255, 102, 0); font-weight: 600;">Pending</strong>
                                            @endif
                                        </td>
                                        <td>
                                        <?php
                                        if(isset($remarks) && !empty($remarks)){  
                                            foreach ($remarks as $remark) { 
                                                if($remark['pr_id'] == $value['Key']){
                                        ?>
                                                <p><strong>Rating: </strong>{{ $remark['rating'] }}</p>
                                                <p>{{ $remark['remark'] }}</p>
                                                <p>By - <strong>{{ $remark['name'] }}</strong></p>
                                        <?php } 
                                            }
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
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