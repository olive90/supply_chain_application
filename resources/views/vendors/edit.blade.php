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
            <a class="btn btn-outline-primary btn-sm" href="{{ route('vendors.index') }}"> << Back</a>
            <br><br>
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
                              <h3 class="card-title">Edit Vendor</h3>
                          </div>
                     </div>                      
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      @if ($errors->any())
                          <div class="alert alert-danger">
                              <strong>Whoops!</strong> There were some problems with your input.<br><br>
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                      <div class="col-md-12">
                          <div class="col-md-3"></div>
                          <div class="col-md-6">
                            <form action="{{ route('vendors.update',$vendor->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                        
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Name:</strong>
                                            <input type="text" name="name" value="{{ $vendor->name }}" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Address:</strong>
                                            <input type="text" name="address" value="{{ $vendor->address }}" class="form-control" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Phone Number:</strong>
                                            <input type="text" name="phone_number" value="{{ $vendor->phone_number }}" class="form-control" placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Category:</strong>
                                            <select name="category" id="category" class="form-control">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" <?= $category->id==$vendor->category?"selected":"" ?>>{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Details:</strong>
                                            <textarea class="form-control" style="height:150px" name="details" placeholder="Details">{{ $vendor->details }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Category:</strong>
                                            <select name="active" id="active" class="form-control">
                                                <option value="Y" <?=$vendor->active=='Y'?"selected":""?>>Active</option>
                                                <option value="N" <?=$vendor->active=='N'?"selected":""?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                          </div>
                          <div class="col-md-3"></div>
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