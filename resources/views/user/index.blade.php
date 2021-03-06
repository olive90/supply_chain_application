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
              <li class="breadcrumb-item active">Users</li>
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
                                <h3 class="card-title">All Users</h3>
                            </div>
                            <div>
                                <a href="{{ route('user.create') }}" class="btn btn-outline-primary">Add New</a>
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

                        <?php if(isset($userList) && !empty($userList)){ ?>
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Create Date</th>
                            <th>Network Permission</th>
                            <th width="100px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            //echo '<pre>';print_r($allData);die;
                                $i=1;
                                foreach ($userList as $user) {
                            ?>
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['address'] }}</td>
                                    <td>
                                      @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                           <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                      @endif
                                    </td>
                                    <td>
                                        <?php if($user['status'] == 1){ ?>
                                        <b style="color: green;">Active</b>
                                        <?php }else{ ?>
                                            <b style="color: red;">Locked</b>
                                        <?php } ?>
                                    </td>
                                    <td>{{ $user['created_at'] }}</td>
                                    <td>
                                      <form action="{{ route('user.destroy',$user['id']) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <?php if($user['write_permission'] == 0){ ?>
                                              <button type="submit" name="revoke" class="btn btn-outline-success">Invoke</button>
                                              <input type="hidden" name="invoke" value="invoke">
                                          <?php }else if($user['write_permission'] == 1){?>
                                            <button type="submit" name="revoke" class="btn btn-outline-danger">Revoke</button>
                                              <input type="hidden" name="revoke" value="revoke">
                                          <?php
                                            }else{ ?>
                                              <strong style="color: red">Revoked</strong>
                                              <input type="hidden" name="invoke" value="invoke">
                                          <?php } ?>
                                      </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.destroy',$user['id']) }}" method="POST">
   
                                            <a href="{{ route('user.edit',$user['id']) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a> |
                           
                                            @csrf
                                            @method('DELETE')
                                            <?php if($user['status'] == 1){ ?>
                                                <button type="submit" name="lock" class="btn btn-outline-danger"><i class="fas fa-user-lock"></i></button>
                                                <input type="hidden" name="lock" value="lock">
                                            <?php }else{ ?>
                                                <button type="submit" name="unlock" class="btn btn-outline-warning"><i class="fas fa-unlock"></i></button>
                                                <input type="hidden" name="unlock" value="unlock">
                                            <?php } ?>
                                        </form>
                                    </td>
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


