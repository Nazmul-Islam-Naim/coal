@extends('layouts.layout')
@section('title', 'LC Fees')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>LC Fees<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">LC Fees</li>
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
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i>LC Fees</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.purchase').'/lc'}}" class="btn btn-primary btn-xs pull-right"><i class="fa-list-alt"></i> <b>LC List</b></a>         
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
                        <form method="get" action="">
                        <div class="form-inline">
                          <div class="form-group">
                            <label>LC No : </label>
                            <input type="text" name="lcno" class="form-control" value="" required="" autocomplete="off">
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
            @if(isset($_GET['lcno']))
            <div class="col-md-6 col-md-offset-3"> 
            {!! Form::open(array('route' =>['lc-fees.store'],'method'=>'POST')) !!}
            @if($row==0)
            <center><h4 style="color: red"><i class="fa fa-warning"></i> {{$single_data}}</h4></center>
            @elseif($row==1)
            <div class="box box-primary">
              <div class="box-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="Group Name">LC No <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" value="{{$single_data->lc_no}}" name="lc_no" required readonly>
                      <input type="hidden" value="{{$single_data->id}}" name="lc_id" required>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">CNF</label>
                      <input type="number" class="form-control" value="" name="cnf" id="Cnf" onkeyup="calculate()">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Duty</label>
                      <input type="number" class="form-control" value="" name="duty" id="Duty" onkeyup="calculate()">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Other</label>
                      <input type="number" class="form-control" value="" name="other" id="Other" onkeyup="calculate()">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Interest</label>
                      <input type="number" class="form-control" value="" name="interest" id="Interest" onkeyup="calculate()">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Labour Cost</label>
                      <input type="number" class="form-control" value="" name="labour_cost" id="LabourCost" onkeyup="calculate()">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Total <span class="text-danger">*</span></label>
                      <input type="number" class="form-control" id="Total" value="" name="total_amount" required readonly>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Payment<span class="text-danger">*</span></label>
                      <select name="bank_id" class="form-control" required>
                          <option value="">--Select--</option>
                          @foreach($allaccounts as $account)
                          <option value="{{$account->id}}">{{$account->bank_name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Date <span class="text-danger">*</span></label>
                      <input type="text" class="form-control datepicker" value="{{date('Y-m-d')}}" name="date" required>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">Note </label>
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
  function calculate(){
      var Cnf = $('#Cnf').val();
      var Duty = $('#Duty').val();
      var Other = $('#Other').val();
      var Interest = $('#Interest').val();
      var LabourCost = $('#LabourCost').val();
      if(isNaN(parseFloat(Cnf))){
          Cnf=0;
      }
      if(isNaN(parseFloat(Duty))){
          Duty=0;
      }
      if(isNaN(parseFloat(Interest))){
          Interest=0;
      }
      if(isNaN(parseFloat(Other))){
          Other=0;
      }
      if(isNaN(parseFloat(LabourCost))){
          LabourCost=0;
      }
      
      var _Total=parseFloat(Cnf)+parseFloat(Duty)+parseFloat(Other)+parseFloat(Interest)+parseFloat(LabourCost);
      $('#Total').val(_Total.toFixed(2));
  }
</script>
@endsection 