@extends('layouts.layout')
@section('title', 'Date Wise Stock Product')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Date Wise Stock Product <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Stock</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Date Wise Stock Product</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.product').'/product'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Products</a>
            </div>
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Product Sale</a>
            </div>-->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12"> 
              <div class="table-responsive">
                <table class="table borderless">
                  <tbody>
                    <tr>
                      <td style="text-align: center;">
                        <form method="get" action="">
                        <div class="form-inline">
                          <div class="form-group">
                            <label>From : </label>
                            <input type="text" name="start_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                          </div>
                          <div class="form-group">
                            <label>To : </label>
                            <input type="text" name="end_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                          </div>
                          <div class="form-group">
                            <input type="submit" value="Search" class="btn btn-success btn-md">
                          </div>
                        </div>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12" id="mydiv">
                @if(!empty($_GET['start_date']) && !empty($_GET['end_date']))
                  <center><h4 style="margin: 0px">From : {{dateFormateForView($_GET['start_date'])}} To : {{dateFormateForView($_GET['end_date'])}}</h4></center>
                @else
                  <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
                @endif
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover dataTableButton" width="100%"> 
                  <thead> 
                    <tr> 
                      <th style="text-align: left">{{ __('messages.SL') }}</th>
                      <th style="text-align: left">Product Name</th>
                      <th style="text-align: left">Product Unit</th>
                      <th style="text-align: left">{{ __('messages.quantity') }}</th>
                      <th style="text-align: left">Average Price</th>
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
                        
                        //$totalPrice += $data->quantity*$data->unit_price;
                      ?>
                    <tr> 
                      <td>{{$currentNumber++}}</td>
                      <td>{{$data->stockproduct_product_object->name}} {{$data->product_id}}</td>
                      <td>
                          <?php 
                            $unitName = DB::table('product_brand')->where('id', $data->stockproduct_product_object->brand_id)->first();
                            echo $unitName->name;
                          ?>
                      </td>
                      <td>
                          <?php 
                          if(!empty($_GET['start_date']) && !empty($_GET['end_date'])){
                            $stockData = DB::table('stock_product_details')->where('product_id', $data->product_id)->where('reason', 'LIKE', '%'.'Add to Stock'.'%')->whereBetween('date', [$_GET['start_date'], $_GET['end_date']])->sum('quantity');
                            $sellData = DB::table('stock_product_details')->where('product_id', $data->product_id)->where('reason', 'LIKE', '%'.'Sell'.'%')->whereBetween('date', [$_GET['start_date'], $_GET['end_date']])->sum('quantity');
                            echo $qnty = $stockData - $sellData;
                            $totalQnty += $qnty;
                          }else{
                            $stockData = DB::table('stock_product_details')->where('product_id', $data->product_id)->where('reason', 'LIKE', '%'.'Add to Stock'.'%')->sum('quantity');
                            $sellData = DB::table('stock_product_details')->where('product_id', $data->product_id)->where('reason', 'LIKE', '%'.'Sell'.'%')->sum('quantity');
                            echo $qnty = $stockData - $sellData;
                            $totalQnty += $qnty; 
                          }
                          ?>
                      </td>
                      <td>
                          <?php 
                            $avrgPrice = DB::table('stock_product')->where('product_id', $data->product_id)->first();
                          ?>
                          {{number_format($avrgPrice->unit_price,2)}}
                      </td>
                      <td>{{number_format($qnty*$avrgPrice->unit_price, 2)}}</td>
                      <?php
                        
                        $totalPrice += $qnty*$avrgPrice->unit_price;
                      ?>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="8" align="center">
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
</section>
<!-- /.content -->
@endsection 