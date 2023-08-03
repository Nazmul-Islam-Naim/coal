@extends('layouts.layout')
@section('title', 'Bill Collection Report')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.bill_collection_report') }} <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.bill_collection_report') }}</h3>

          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Sell Product</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collection'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus-circle"></i> <b>Bill Collection</b></a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Accounts</a>
            </div>
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("custom/img/print.png")}}'></a></div>
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
                        <form method="post" action="{{ route('bill-collection.filter') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-inline">
                            <div class="form-group">
                              <label>From : </label>
                              <input type="date" name="start_date" class="form-control" value="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="form-group">
                              <label>To : </label>
                              <input type="date" name="end_date" class="form-control" value="<?php echo date('Y-m-d');?>">
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
              <center><h4 style="margin: 0px">Bill COllection Report</h4></center>
              <div class="table-responsive">
                @if(!empty($start_date) && !empty($end_date))
                  <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
                @else
                  <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
                @endif
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.id') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.name') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.email') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.phone') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px" width="15%">{{ __('messages.amount') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                      $total = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++; 
                        $total += $data->amount;
                      ?>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->ledger_customer_object->customer_id}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->customer_id}}" target="_blank">{{$data->ledger_customer_object->name}}</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->ledger_customer_object->email}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->ledger_customer_object->phone}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"> 
                        {{number_format($data->amount, 2)}}
                      </td>
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
                      <td colspan="5" style="text-align: center;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($total,2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                    {{$alldata->render()}}
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
  </div>
</section>
<!-- /.content -->
@endsection 