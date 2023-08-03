@extends('layouts.layout')
@section('title', 'Discount On Purchase Report')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Discount On Purchase Report <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report</li>
  </ol>
</section>
<style type="text/css">
  .borderless td, .borderless th {
    border: none!important;
  }
</style>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Discount On Purchase Report</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Supplier</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.purchase').'/product-purchase'}}" class="btn btn-success btn-xs"><i class="fa fa-get-pocket"></i> Product Purchase</a>
            </div>
            <!--<div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("custom/img/print.png")}}'></a></div>
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
                        <form method="post" action="{{ route('purchase.filter') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-inline">
                            <div class="form-group">
                              <label>From : </label>
                              <input type="text" name="start_date" class="form-control datepicker" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <label>To : </label>
                              <input type="text" name="end_date" class="form-control datepicker" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <label>Supplier : </label>
                              <input type="text" name="input" class="form-control" value="">
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
           
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">Discount On Purchase Report</h4></center>
              @if(!empty($start_date) && !empty($end_date))
                <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.supplier') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.invoice') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.created_by') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Discount</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.row_total') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                      $afterDis = 0;
                      $totalPrice = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $totalPrice += $data->sub_total-$data->discount;
                      ?>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">
                        {{$currentNumber++}}
                      </td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->purchase_date)}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->productpurchase_supplier_object->name}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.purchase').'/purchase-report/'.$data->tok}}">{{$data->tok}}</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->productpurchase_createdby_object->name}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->discount, 2)}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->sub_total-$data->discount, 2)}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal_{{$data->tok}}">Discount</button>
                            <!-- Modal -->
                            <div id="myModal_{{$data->tok}}" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Discount On Purchase</h4>
                                  </div>
                                  {!! Form::open(array('route' =>['save-discount-on-purchase'],'method'=>'POST')) !!}
                                  <div class="modal-body">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" step="any" class="form-control" value="{{$data->sub_total-$data->discount}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" step="any" class="form-control" name="discount" value="" autocomplete="off">
                                        <input type="hidden" name="tok" value="{{$data->tok}}">
                                        <input type="hidden" name="supplier_id" value="{{$data->supplier_id}}">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                  </div>
                                  {!! Form::close() !!}
                                </div>
                            
                              </div>
                            </div>
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="7" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="6" style="text-align: center;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalPrice, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">{{$alldata->render()}}</div>
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