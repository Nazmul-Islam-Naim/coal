@extends('layouts.layout')
@section('title', 'Amount Withdraw')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.bank_withdraw') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Withdraw</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border"></div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(array('route' =>['amount-withdraw.store'],'method'=>'POST')) !!}
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.bank') }} {{ __('messages.name') }}</label>
                  <input type="text" class="form-control" value="{{$alldata->bank_name}}" readonly="">
                  <input type="hidden" class="form-control" name="bank_id" value="{{$alldata->id}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.account_name') }}</label>
                  <input type="text" class="form-control" value="{{$alldata->account_name}}" readonly="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.account_no') }}</label>
                  <input type="text" class="form-control" value="{{$alldata->account_no}}" readonly="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>Available Amount</label>
                  <input type="text" class="form-control" value="{{$alldata->balance}}" readonly="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.cheque_book') }} <span style="color: red">*</span></label>
                  <select class="form-control Checkbook" name="check_book" required=""> 
                    <option value="">--Selcct--</option>
                    @foreach($allchequebook as $chequebook)
                    <option value="{{$chequebook->id}}">{{$chequebook->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.cheque_no') }} <span style="color: red">*</span></label>
                  <select class="form-control Checkno" name="check_no" required=""> 
                    
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.amount') }} <span style="color: red">*</span></label>
                  <input type="number" step="any" name="withdraw_amount" class="form-control" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.date') }} <span style="color: red">*</span></label>
                  <input type="text" name="transaction_date" class="form-control datepicker" value="{{date('Y-m-d')}}" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.note') }}</label>
                  <textarea class="form-control" name="note"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  {{Form::submit('Withdraw',array('class'=>'btn btn-success', 'style'=>'width:100%'))}}
                </div>
              </div>
            </div>
          <!-- /.row -->
          </div>
          {!! Form::close() !!}
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<?php
  $baseUrl = URL::to('/');
?>

<script type="text/javascript"> 
  // dependancy dropdown using ajax
  $(document).ready(function() {
    $('.Checkbook').on('change', function() {
      var chequeBookID = $(this).val();
      if(chequeBookID) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          //url: "{{URL::to('find-chequeno-with-chequebook-id')}}",
          url: "{{$baseUrl.'/'.config('app.account').'/find-chequeno-with-chequebook-id'}}",
          data: {
            'id' : chequeBookID
          },
          dataType: "json",

          success:function(data) {
           // console.log(data);
            if(data){
              $('.Checkno').empty();
              $('.Checkno').focus;
              $('.Checkno').append('<option value="">Select</option>');
              $.each(data, function(key, value){
                console.log(data);
                $('select[name="check_no"]').append('<option value="'+ value.id +'">' + value.cheque_no+ '</option>');
              });
            }else{
              $('.Checkno').empty();
            }
          }
        });
      }else{
        $('.Checkno').empty();
      }
    });
  });
</script>
@endsection 