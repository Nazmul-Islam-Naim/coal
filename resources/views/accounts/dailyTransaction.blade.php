@extends('layouts.layout')
@section('title', 'Daily Transaction')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.daily_transaction') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.report') }}</li>
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
          <h4 class="box-title"> {{ __('messages.daily_transaction') }}</h4>
          <div class="form-inline pull-right">
            <div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-info btn-xs pull-right"><i class="fa fa-institution"></i> {{ __('messages.accounts') }}</a>    
            </div>
            <div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher'}}" class="btn btn-warning btn-xs pull-right"><i class="fa fa-get-pocket"></i> {{ __('messages.receive_voucher') }}</a>     
            </div>
            <div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher'}}" class="btn btn-primary btn-xs pull-right"><i class="fa fa-money"></i> {{ __('messages.payment_voucher') }}</a>     
            </div>
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
                        <form method="post" action="{{ route('transaction.filter') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">{{ __('messages.daily_transaction_report') }}</h4></center>
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
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.reason') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.note') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.payment_method') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.receive') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.payment') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.balance') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 250; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $sum = 0;
                      $debit = 0;
                      $credit = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php $rowCount++; ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php echo dateFormateForView($data->transaction_date); ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px; width: 10%">{{ucfirst($data->note)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->transactionreport_bank_object->bank_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          $reasons = $data->reason;

                          if(preg_match("/Opening Balance/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }elseif (preg_match("/deposit/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }elseif (preg_match("/receive/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          if(preg_match("/withdraw/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }elseif (preg_match("/transfer/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }elseif (preg_match("/payment/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        {{number_format($sum, 2)}}
                      </td>
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
                      <td colspan="5" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} <?php echo number_format($credit, 2);?></b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} <?php echo number_format($debit, 2);?></b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} <?php echo number_format($sum, 2);?></b></td>
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