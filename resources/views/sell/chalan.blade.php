@extends('layouts.layout')
@section('title', 'Create Chalan')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<style type="text/css">
  .select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}
</style>
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <!-- <h1> PURCHASE PRODUCT <small></small> </h1> -->
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">Create Chalan</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    {!! Form::open(array('route' =>['chalan.store'],'method'=>'POST')) !!}
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Create Chalan</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Buyer Name <span style="color: red">*</span></label>
                <input type="text" name="buyer_name" class="form-control" value="" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Address <span style="color: red">*</span></label>
                <input type="text" name="address" class="form-control" value="" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>From <span style="color: red">*</span></label>
                <input type="text" name="chalan_from" class="form-control" value="" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>To <span style="color: red">*</span></label>
                <input type="text" name="chalan_to" class="form-control" value="" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.date') }} <span style="color: red">*</span></label>
                <input type="text" name="date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" required="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.note') }}</label>
                <textarea class="form-control" name="note" rows="1"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Product Details</label>
                <textarea class="form-control" name="details" rows="1"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="panel panel-primary">
                <div class="panel-body"> 
                  <div class="table-responsive"> 
                  <table class="table"> 
                    <thead> 
                      <tr>
                        <th style="text-align: center">Truck No. <span style="color: red">*</span></th>
                        <!--<th style="text-align: center">Type</th>-->
                        <th style="text-align: center">Length <span style="color: red">*</span></th>
                        <th style="text-align: center">Width <span style="color: red">*</span></th>
                        <th style="text-align: center">Height <span style="color: red">*</span></th>
                        <th style="text-align: center">CFT</th>
                        <!--<th style="text-align: center">Conversion</th>
                        <th style="text-align: center">Quantity (MT)</th>-->
                        <th style="text-align: center">M.T</th> 
                      </tr> 
                    </thead>
                    <?php $row_num = 1; ?>
                    <tbody class="row_container"> 
                       <tr>
                           <td><input type="text" class="form-control" name="truck_no"></td>
                           <td><input type="text" class="form-control" name="length"></td>
                           <td><input type="text" class="form-control" name="width"></td>
                           <td><input type="text" class="form-control" name="height"></td>
                           <td><input type="text" class="form-control" name="cft"></td>
                           <td><input type="text" class="form-control" name="mt"></td>
                       </tr>
                    </tbody> 
                    <tfoot>
                      <tr> 
                        <td colspan="6" style="text-align: right">
                          <button type="submit" name="purchase" class="btn btn-md btn-success"><i class="fa fa-shopping-cart" onclick="return confirm('Are you sure?')"></i> Create Chalan</button>
                        </td>
                        <td></td>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
    {!! Form::close() !!}
  </div>
</section>
<!-- /.content -->
@endsection