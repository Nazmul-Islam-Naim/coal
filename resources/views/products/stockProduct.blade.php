@extends('layouts.layout')
@section('title', 'Stock Product')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.main_stock') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.main_stock') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.stock_product') }} {{ __('messages.list') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.product').'/product'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> {{ __('messages.product') }}</a>
            </div>
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Product Sale</a>
            </div>-->
            <a href="#addPreviousStcok" data-toggle="modal" class="btn btn-info btn-sm "><i class="fa fa-plus-circle"></i> {{ __('messages.previous_product_to_main_stock') }}</a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="mydiv">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover dataTableButton" width="100%"> 
                  <thead> 
                    <tr> 
                      <th style="text-align: left">{{ __('messages.SL') }}</th>
                      <th style="text-align: left">{{ __('messages.product') }}</th>
                      <th style="text-align: left">{{ __('messages.product_unit') }}</th>
                      <th style="text-align: left">{{ __('messages.quantity') }}</th>
                      <th style="text-align: left">{{ __('messages.unit_price') }} (Avrg)</th>
                      <th style="text-align: left">{{ __('messages.row_total') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $totalQnty = 0;
                      $totalPrice = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++; 
                        $totalQnty += $data->quantity;
                        $totalPrice += $data->quantity*$data->unit_price;
                      ?>
                    <tr> 
                      <td>{{$currentNumber++}}</td>
                      <td>{{$data->stockproduct_product_object->name}}</td>
                      <td>
                          <?php 
                            $unitName = DB::table('product_unit')->where('id', $data->stockproduct_product_object->unit_id)->first();
                            echo $unitName->name;
                          ?>
                      </td>
                      <td>{{$data->quantity}}</td>
                      <td>{{number_format($data->unit_price,2)}}</td>
                      <td>{{number_format($data->quantity*$data->unit_price, 2)}}</td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="6" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr> 
                      <td colspan="3" style="text-align: center"><b>{{ __('messages.total') }}</b></td>
                      <td><b>{{number_format($totalQnty,2)}}</b></td>
                      <td></td>
                      <td><b>{{number_format($totalPrice,2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right"></div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
  </div>
  
  <!-- Start Modal for edit Class -->
 <div id="addPreviousStcok" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> {{ __('messages.previous_product_to_main_stock') }}</h4>
      </div>

      {!! Form::open(array('route' =>['add-pre-main-stock'],'method'=>'POST')) !!}
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12">
           <div class="form-group"> 
                <label>{{ __('messages.product') }} <strong style="color:red">*</strong></label>
                <select name="product_id" class="form-control select2" required="">
                  <option value="">--Select--</option>
                  @foreach(\App\Models\Product::all() as $value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group"> 
              <label>{{ __('messages.quantity') }}<span style="color:red">*</span></label>
              <input type="text" name="quantity" class="form-control" value="" autocomplete="off" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group"> 
              <label>{{ __('messages.unit_price') }}<span style="color:red">*</span></label>
              <input type="text" name="unit_price" class="form-control" value="" autocomplete="off" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group"> 
              <label>{{ __('messages.date') }}</label>
              <input type="text" name="date" class="form-control datepicker" value="{{date('Y-m-d')}}" autocomplete="off" >
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        {{Form::submit('Update',array('class'=>'btn btn-success btn-sm', 'style'=>'width:25%'))}}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
</section>
<!-- /.content -->
@endsection 