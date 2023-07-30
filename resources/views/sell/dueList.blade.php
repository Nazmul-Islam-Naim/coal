@extends('layouts.layout')
@section('title', 'Due List')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Due List <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Due List</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.sell').'/pos-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> POS Sale</a>    
            </div>-->
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>
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
                        <form method="post" action="{{ route('due-list.filter') }}">
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
                              <label>Customer/Job Card/Reg. : </label>
                              <input type="text" name="input" class="form-control" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <input type="submit" name="search" value="Search" class="btn btn-success btn-md">
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
              <center><h4 style="margin: 0px">Due List</h4></center>
              @if(!empty($start_date) && !empty($end_date))
                <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Job No</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Reg. No</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Customer</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Job Card</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total Bill</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total Vat</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Due</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $totalSell = 0;
                      $totalVat = 0;
                      $totalDue = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        if($data->total_amount != $data->paid_amount){
                      ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->job_card_date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.sell').'/job-card-invoice/'.$data->tok}}">{{$data->job_card_no}}</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->reg_no}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->customer_id}}">{{$data->productsell_customer_object->name}}</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.sell').'/job-card-invoice/'.$data->tok}}">Job Card</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->total_amount, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->vat_amount, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format(($data->total_amount-($data->paid_amount+$data->discount)), 2)}}</td>
                    </tr>
                    <?php
                      $totalSell += $data->total_amount;
                      $totalVat += $data->vat_amount;
                      $totalDue += $data->total_amount-($data->paid_amount+$data->discount);
                    }
                    ?>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="10" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="6" style="text-align: center;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalSell, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalVat, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalDue, 2)}}</b></td>
                      
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