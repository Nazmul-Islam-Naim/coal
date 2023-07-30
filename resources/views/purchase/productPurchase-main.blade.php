@extends('layouts.layout')
@section('title', 'Purchase Product')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> PURCHASE PRODUCT <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">PURCHASE</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    {!! Form::open(array('route' =>['product-purchase.store'],'method'=>'POST')) !!}
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Purchase Product</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Supplier</label>
                <select class="form-control" name="cus_sup_id"> 
                  <option value="">Select</option>
                  @foreach($allsupplier as $supplier)
                  <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>Product</label>
                <select class="form-control" name="product_id"> 
                  <option value="">Select</option>
                  @foreach($allproduct as $product)
                  <option value="{{$product->id}}">{{$product->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>Unit Price</label>
                <input type="text" name="unit_price" class="form-control" value="" id="unitPrice" onkeyup="total(this.value, Quantity.value);">
              </div>
              <div class="form-group"> 
                <label>Quantity</label>
                <input type="text" name="quantity" class="form-control" value="" id="Quantity" onkeyup="total(this.value, unitPrice.value);">
              </div>
              <div class="form-group"> 
                <label>Total</label>
                <input type="text" class="form-control" value="" id="Total">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-success" style="width: 100%" name="add_to_cart" value="Add to Crat">
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
    
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> CART LIST</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover"> 
                  <thead> 
                    <tr> 
                      <th>SL</th>
                      <th>Supplier</th>
                      <th>Product</th>
                      <th>Unit Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th width="15%">Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php $rowCount++; ?>
                    <tr> 
                      <td>
                        <label class="label label-success">{{$currentNumber++}}</label>
                      </td>
                      <td>{{$data->cart_supplier_object->name}}</td>
                      <td>{{$data->cart_rowproduct_object->name}}</td>
                      <td>{{$data->unit_price}}</td>
                      <td>{{$data->quantity}}</td>
                      <td>{{$data->unit_price*$data->quantity}}</td>
                      <td>
                        <div class="form-inline">
                          <div class="input-group">
                              <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="7" align="center">
                          <h4 style="color: #ccc">Cart is Empty . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-md-12" align="right"></div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"> 
          <?php
            $countCart = DB::table('cart')->where('type', 'like', '%' . 'purchase' . '%')->where('session', Session::get('purchaseSession'))->get();
            if(count($countCart) != '0'){
          ?>
          <input type="submit" class="btn btn-success" name="purchase" value="Purchase"> 
          <?php
            }
          ?>         
        </div>
      </div>
      <!-- /.box -->
    </div>
    {!! Form::close() !!}
  </div>
</section>
<!-- /.content -->

<script type="text/javascript"> 
  function total(x, y){
    var total = parseInt(x)*parseInt(y);
    //console.log(total);
    if (isNaN(total)) {
      document.getElementById('Total').value = 0;
    }else{
      document.getElementById('Total').value = total;
    }
  }
</script>
@endsection 