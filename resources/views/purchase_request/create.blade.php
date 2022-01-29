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
        <a class="btn btn-outline-primary btn-sm" href="{{ route('pr.index') }}"> << Back</a>
        <br><br>
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
                              <h3 class="card-title">Purchase Request Form</h3>
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
                            <form action="{{ route('products.store') }}" method="POST">
                                @csrf
                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left: 0px !important;">
                                            <div class="form-group">
                                                <strong>Category:</strong>
                                                <select class="form-control" name="category">
                                                    <option value="">Select One</option>
                                                    <?php if(isset($categories) && !empty($categories)){ ?>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category['id'] }}">{{ $category['category_name'] }}</option>
                                                        @endforeach
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left: 0px !important;">
                                            <div class="form-group">
                                                <strong>Expected Delivery Date:</strong>
                                                <input type="date" name="pr_date" value="<?=date('m-d-Y');?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-left: 0px !important;">
                                        <br>
                                        <div class="col-md-4">
                                            <input class="btn btn-outline-success" type="button" name="" id="add" value="Add More Product/Item">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" id="product">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-md-4" style="float: left;">
                                                <div class="form-group">
                                                    <strong>Product/Item:</strong>
                                                    <select class="form-control" name="product" onchange="getPrice(this, this.value)">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2" style="float: left;">
                                                <div class="form-group">
                                                    <strong>Qty:</strong>
                                                    <input type="text" class="form-control" name="qty" id="qty">
                                                </div>
                                            </div>
                                            {{-- <div class="col-xs-2 col-sm-2 col-md-2" style="float: left;">
                                                <div class="form-group">
                                                    <strong>Per Unit Price:</strong>
                                                    <input type="text" class="form-control unit_price" name="unit_price" id="unit_price">
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2" style="float: left;">
                                                <div class="form-group">
                                                    <strong>Total Price:</strong>
                                                    <input type="text" class="form-control" name="total_price" id="total_price">
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4"></div>
                                                <div class="col-xs-2 col-sm-2 col-md-2"></div>
                                                <div class="col-xs-2 col-sm-2 col-md-2"></div>
                                                <div class="col-xs-2 col-sm-2 col-md-2">
                                                    <div class="form-group">
                                                        <strong>Grand Total:</strong>
                                                        <input type="text" class="form-control" value="0" name="grand_total" id="grand_total">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <strong>Address 1:</strong>
                                                    <input type="text" name="address1" class="form-control" placeholder="Address Line 1">
                                                </div>
                                            </div>
        
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <strong>Address 2:</strong>
                                                    <input type="text" name="address2" class="form-control" placeholder="Address Line 2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <strong>Phone:</strong>
                                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-8 col-md-8">
                                                <div class="form-group">
                                                    <strong>Special Ordering Instructions:</strong>
                                                    <textarea name="instructions" class="form-control" placeholder="Special Ordering Instructions"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-8 col-md-8">
                                                <div class="form-group">
                                                    <strong>Shipping Instructions:</strong>
                                                    <textarea name="instructions" class="form-control" placeholder="Shipping Instructions"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-outline-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
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

<div id="product_copy" style="display:none">
    <div class="col-xs-12 col-sm-12 col-md-12 control-group" style="padding-left: 0px !important;">
        <div class="col-xs-4 col-sm-4 col-md-4" style="float: left;">
            <div class="form-group">
                <strong>Product/Item:</strong>
                <select class="form-control" name="product" onchange="getPrice(this, this.value)">
                    <option value="">Select One</option>
                </select>
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2" style="float: left;">
            <div class="form-group">
                <strong>Qty:</strong>
                <input type="text" class="form-control" name="qty" id="qty">
            </div>
        </div>
        {{-- <div class="col-xs-2 col-sm-2 col-md-2" style="float: left;">
            <div class="form-group">
                <strong>Per Unit Price:</strong>
                <input type="text" class="form-control unit_price" name="unit_price" id="unit_price">
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2" style="float: left;">
            <div class="form-group">
                <strong>Total Price:</strong>
                <input type="text" class="form-control" name="total_price" id="total_price">
            </div>
        </div> --}}
        <div class="col-xs-2 col-sm-2 col-md-2" style="float: left;">
            <br>
            <input class="btn btn-outline-danger btn-sm remove" type="button" value="Remove">
        </div>
    </div>
</div>

@endsection 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var qtyId = 1;
        $("#add").click(function(e) {
            e.preventDefault();
            
            var html = $("#product_copy").html();
            
            $("#qty").attr("id", "qty_" + qtyId);
            qtyId++;

            $("#product").after(html);

        });

        $("body").on("click",".remove",function(e){ 
            e.preventDefault();
            $(this).parents(".control-group").remove();

        });

        $( "select[name='category']" ).change(function () {
        var categoryId = $(this).val();
        var html = '';
        if(categoryId) {
            $.ajax({
                url: "{{ URL('product') }}",
                dataType: 'Json',
                data: {'categoryId':categoryId},
                success: function(data) {
                    $("select[name='category']").prop('disabled',true);
                    $('select[name="product"]').empty();
                    html = '<option value="">Select Product</option>';
                    $.each(data, function(key, value) {
                        html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });
                    $('select[name="product"]').append(html);
                }
            });
        }else{
            $('select[name="product"]').empty();
        }

        });
    });

    function getPrice(x, productid){
        // console.log(productid);
        var html = '';
        if(productid) {
            $.ajax({
                url: "{{ URL('product_price') }}",
                dataType: 'Json',
                data: {'productId':productid},
                success: function(data) {
                    
                    quantity = $(x).parents().parents()[0]['children'][0];
                    console.log(quantity);
                    //$('input[name="qty"]').val(1);
                    $.each(data, function(key, value) {
                        $('.unit_price').val(value.unit_price);
                    });
                }
            });
        }else{
            $('.unit_price').val('');
        }
    }

</script>