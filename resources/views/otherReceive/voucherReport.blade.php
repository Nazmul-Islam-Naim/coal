@extends('layouts.layout')
@section('title', 'Other Receive Voucher')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.receive_voucher_report') }} <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.receive_voucher_report') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher'}}" class="btn btn-warning btn-xs pull-right"><i class="fa fa-plus-circle"></i> <b>ADD VOUCHER</b></a>          
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
                        <form method="post" action="{{ route('receive.filter') }}">
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
              <center><h4 style="margin: 0px">{{ __('messages.receive_voucher_report') }}</h4></center>
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
                      <!--<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.invoice') }}</th>-->
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.receive_method') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.type') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.sub_type') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.issue_by') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.note') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.created_by') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.amount') }}</th>
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
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $sum += $data->amount;
                      ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        {{$currentNumber++}}
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->receive_date)}}</td>
                      <!--<td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{URL::To('other-receive/recevie-voucher-detail',$data->id)}}">Invoice</a></td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->otherreceive_bank_object->bank_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->otherreceive_type_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->otherreceive_subtype_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->issue_by}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->otherreceive_user_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->amount, 2)}}</td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="9" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="8" style="text-align: center; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($sum, 2)}}</b></td>
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