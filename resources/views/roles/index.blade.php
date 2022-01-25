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
        <h1 class="m-0">User Manager</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Roles</li>
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
                              <h3 class="card-title">Role Management</h3>
                          </div>
                          <div>
                            @can('role-create')
                                <a class="btn btn-outline-primary" href="{{ route('roles.create') }}"> Create New Role</a>
                            @endcan
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

                      <?php if(isset($roles) && !empty($roles)){ ?>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th width="100px">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @can('role-edit')
                                    <a class="btn btn-outline-primary" href="{{ route('roles.edit',$role->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!! $roles->render() !!}
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