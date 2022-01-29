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
        <h1 class="m-0">Products</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
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
                              <h3 class="card-title">All Products</h3>
                          </div>
                          <div>
                            @can('role-create')
                                <a class="btn btn-outline-primary" href="{{ route('products.create') }}"> Create New</a>
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

                      <?php if(isset($products) && !empty($products)){ ?>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Unit Price</th>
                        <th>Details</th>
                        <th>Vendor</th>
                        <th>Create Date</th>
                        <th>Status</th>
                        <th width="100px">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->unit_price }} TK</td>
                            <td>{{ $product->details }}</td>
                            <td>{{ $product->vendor_name }}</td>
                            <td>{{ $product->created_at }}</td>
                            @if($product->Active == 'Y')
                            <td style="color: green; font-weight: 600;">Active</td>
                            @else
                            <td style="color: red; font-weight: 600;">In Active</td>
                            @endif
                            <td>
                                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                    @can('product-edit')
                                    <a class="btn btn-outline-primary" href="{{ route('products.edit',$product->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan


                                    @csrf
                                    @method('DELETE')
                                    @can('product-delete')
                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                                    @endcan
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