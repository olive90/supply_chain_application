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
        <h1 class="m-0">Vendors</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Vendors</li>
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
                              <h3 class="card-title">All Vendors</h3>
                          </div>
                          <div>
                            @hasrole('Admin')
                                <a class="btn btn-outline-primary" href="{{ route('vendors.create') }}"> Create New</a>
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

                      <?php if(isset($vendors) && !empty($vendors)){ ?>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Details</th>
                        <th>Create Date</th>
                        <th>Status</th>
                        <th width="100px">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->address }}</td>
                            <td>{{ $vendor->phone_number }}</td>
                            <td>{{ $vendor->details }}</td>
                            <td>{{ $vendor->created_at }}</td>
                            @if($vendor->Active == 'Y')
                            <td style="color: green; font-weight: 600;">Active</td>
                            @else
                            <td style="color: red; font-weight: 600;">In Active</td>
                            @endif
                            <td>
                                <form action="{{ route('vendors.destroy',$vendor->id) }}" method="POST">
                                  @hasrole('Admin')
                                    <a class="btn btn-outline-primary" href="{{ route('vendors.edit',$vendor->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                  @endhasrole

                                    @csrf
                                    @method('DELETE')
                                    @hasrole('Admin')
                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                                    @endhasrole
                                </form>
                            </td>
                        </tr>
                        @endforeach
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