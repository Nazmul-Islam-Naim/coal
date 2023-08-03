@extends('layouts.layout')
@section('title', 'LC Payment')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>{{ __('messages.LC_payment') }}<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.LC_payment') }}</li>
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
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i>{{ __('messages.LC_payment') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.purchase').'/lc'}}" class="btn btn-primary btn-xs pull-right"><i class="fa-list-alt"></i> <b>{{ __('messages.LC_list') }}</b></a>         
            </div>
            <!--<div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
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
                        <form method="get" action="{{ route('lc-payment.index') }}">
                          <div class="form-inline">
                            <div class="form-group">
                              <select class="form-control select2" name="lc_no">
                                  <option value="">Select Lc No</option>
                                  @foreach($lcInfos as $lcInfo)
                                  <option value="{{$lcInfo->lc_no}}">{{$lcInfo->lc_no}}</option>
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
            @if(!empty($lc_no))
            <div class="col-md-6 col-md-offset-3"> 
            {!! Form::open(array('route' =>['lc-payment.store'],'method'=>'POST')) !!}
            @if($row==0)
            <center><h4 style="color: red"><i class="fa fa-warning"></i> {{$single_data}}</h4></center>
            @elseif($row==1)
            <div class="box box-primary">
              <div class="box-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.LC_No') }} <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" value="{{$single_data->lc_no}}" name="lc_no" required readonly>
                      <input type="hidden" value="{{$single_data->id}}" name="lc_id" required>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.Bank_Due') }} ($) <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" value="{{$single_data->bank_due}}" id="totalDue" name="bank_due" required readonly>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.Dollar_Rate') }} (BDT) <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" value="" name="dollar_rate" required onkeyup="calculate(this.value)">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.Bank_Due') }} (BDT) <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="restDue" value="" name="amount" required readonly>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.bank') }}<span class="text-danger">*</span></label>
                      <select name="bank_id" class="form-control" required>
                          <option value="">--Select--</option>
                          @foreach($allaccounts as $account)
                          <option value="{{$account->id}}">{{$account->bank_name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.date') }} <span class="text-danger">*</span></label>
                      <input type="text" class="form-control datepicker" value="{{date('Y-m-d')}}" name="date" required>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.note') }} </label>
                      <textarea rows="1" class="form-control" value="" name="note"></textarea>
                    </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success btn-md" onclick="return confirm('Are you sure?')">Payment</button>
              </div>
            </div>
            @endif
            {!! Form::close() !!}
            </div>
            @endif
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
<script type="text/javascript">
  function calculate(value){
      var totalDue = $('#totalDue').val();
      if(isNaN(value)){
          value=0;
      }
      
      var _restDue=parseFloat(totalDue)*parseFloat(value);
      $('#restDue').val(_restDue.toFixed(2));
  }
</script>
@endsection 