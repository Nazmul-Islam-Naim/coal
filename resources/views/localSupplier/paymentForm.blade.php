@extends('layouts.layout')
@section('title', 'Local Supplier Payment Form')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Local Supplier <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.type') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Local Supplier Payment Form</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['payment-store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <h5>Name: {{$payableSupplier->name}} || 
                Phone: {{$payableSupplier->phone}} || 
                Emai: {{$payableSupplier->email}} ||
                Address: {{$payableSupplier->address}} ||
                Bill: {{$payableSupplier->bill}} ||
                Payment: {{$payableSupplier->payment}} ||
                Due: {{$payableSupplier->due}}
              </h5>
            </div>
            <input type="hidden" value="{{$payableSupplier->due}}" id="due">
            <input type="hidden" name="local_supplier_id" value="{{$payableSupplier->id}}">
            <input type="hidden" name="supplier_name" value="{{$payableSupplier->name}}">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Enter Amount <span style="color:red">*</span></label>
                <input type="number" name="amount" step="any" id="amount" class="form-control" value="" placeholder="560005" required autocomplete="off">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Payment Method <span style="color:red">*</span></label>
                <select class="form-control Type select2" name="bank_account_id" required=""> 
                  <option value="">Select account</option>
                  @foreach($bankAccounts as $bankAccount)
                  <option value="{{$bankAccount->id}}">{{$bankAccount->bank_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Payment Date<span style="color:red">*</span></label>
                <input type="date" name="date"  class="form-control" value="{{date('Y-m-d')}}" required autocomplete="off">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Note</label>
                <input type="text" name="note" class="form-control" value="" placeholder="short description" autocomplete="off">
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer text-right">
          <button class="btn btn-primary btn-sm"> Payment</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<script>
  $(document).ready(function () {
    $('#amount').keyup(function (e) { 
      var amount = parseFloat($(this).val());
      var due = parseFloat($('#due').val());
      if (amount > due) {
        alert('Value is greater than due amount !');
        $(this).val(0);
      }
    });
  });
</script>
@endsection 