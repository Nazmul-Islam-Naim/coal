@extends('layouts.layout')
@section('title', 'LC Fee Payments Report')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>  LC Fee Payments Report <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> LC Fee Payments Report</h3>
          <div class="form-inline pull-right">
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
                        <form method="get" action="{{ route('lc-fee-payments-report') }}">
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
                              <select name="lc_no" class="form-control select2">
                                <option value="">Select Lc No</option>
                                @foreach($lcInfos as $lcInfo)
                                <option value="{{$lcInfo->lc_no}}">
                                  {{$lcInfo->lc_no}}
                                </option>
                                @endforeach
                              </select>
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
              <center><h4 style="margin: 0px"> LC Fee Payments Report</h4></center>
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
                      <th style="border: 1px solid #ddd; padding: 3px 3px">LC No</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Fees Title</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Payment Method</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Note</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Amount</th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach($lcFeesPayments as $key => $data)
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        {{$key+1}}
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->lc_no}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->feesType->name ?? ''}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->bank->bank_name ?? ''}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->amount, 2)}}</td>
                    </tr>
                    @endforeach
                    @if($lcFeesPayments->count() == 0)
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
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($lcFeesPayments->sum('amount'), 2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">{{$lcFeesPayments->render()}}</div>
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