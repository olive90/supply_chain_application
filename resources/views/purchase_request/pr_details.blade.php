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
                        
                    </div>
                    <div class="row table-responsive">
                        <?php if(isset($allData) && !empty($allData)){ ?>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>SL#</th>
                                    <th>PRNo</th>
                                    <th>PR Purpose</th>
                                    <th>Request Date & Time</th>
                                    <th>PR Status</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // echo '<pre>';print_r($allData);die;
                                    $i=1;
                                    foreach ($allData as $value) {
                                        $pr_key = base64_encode($value['Key']);
                                ?>
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <a href="{{ route('pr.show', $pr_key) }}" target="_blank">
                                                {{ $value['Record']['PRNo'] }}
                                            </a>
                                        </td>
                                        <td>{{ $value['Record']['PRPurpose'] }}</td>
                                        <td>{{ $value['Record']['PRRequestDate'] }}</td>
                                        @if ($value['Record']['PRStatus'] == 1)
                                            <td style="color: green; font-weight: 600;">Processing</td>
                                        @else
                                            <td style="color: red; font-weight: 600;">InActive</td>
                                        @endif
                                        <td>
                                            <form action="{{ route('products.destroy', $pr_key) }}" method="POST">
                                                
                                                <a class="btn btn-outline-primary" href="{{ route('products.edit', $pr_key) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                @csrf
                                                @method('DELETE')
                                                
                                                <button type="submit" class="btn btn-outline-warning"><i class="fas fa-eye"></i></button>
                                                
                                            </form>
                                        </td>
                                    </tr>
                                <?php
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