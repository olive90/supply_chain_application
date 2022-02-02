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
        <h1 class="m-0">Purchase Request</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Purchase Request</li>
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
                              <h3 class="card-title">All Purchase Request</h3>
                          </div>
                          <div>
                            @hasrole('User')
                                <a class="btn btn-outline-primary" href="{{ route('pr.create') }}"> Make New Request</a>
                            @endhasrole
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
                    <div class="row table-responsive">
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
                                ?>
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $value['Record']['PRNo'] }}</td>
                                        <td>{{ $value['Record']['PRPurpose'] }}</td>
                                        <td>{{ $value['Record']['PRRequestDate'] }}</td>
                                        @if ($value['Record']['PRStatus'] == 1)
                                            <td style="color: green; font-weight: 600;">Processing</td>
                                        @else
                                            <td style="color: red; font-weight: 600;">InActive</td>
                                        @endif
                                        <td>
                                            <form action="{{ route('products.destroy',$value['Key']) }}" method="POST">
                                                
                                                <a class="btn btn-outline-primary" href="{{ route('products.edit',$value['Key']) }}">
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