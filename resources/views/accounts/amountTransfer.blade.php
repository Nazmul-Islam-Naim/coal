@extends('layouts.layout')
@section('title', 'Amount Transfer')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.bank_transfer') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Transfer</li>
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
          {!! Form::open(array('route' =>['amount-transfer.store'],'method'=>'POST')) !!}
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
                  <label>Available Amount <span style="color: red">*</span></label>
                  <input type="text" class="form-control" value="{{$alldata->balance}}" readonly="" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.transfer_to') }} <span style="color: red">*</span></label>
                  <select class="form-control" name="transfer_to" required=""> 
                    <option value="">--Selcct--</option>
                    @foreach($allbank as $bank)
                    <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>{{ __('messages.amount') }} <span style="color: red">*</span></label>
                  <input type="number" name="transfer_amount" class="form-control" required="">
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
                  {{Form::submit('Transfer',array('class'=>'btn btn-success', 'style'=>'width:100%'))}}
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
@endsection 