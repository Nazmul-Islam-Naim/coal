@extends('layouts.layout')
@section('title', 'Local Supplier')
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
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-pencil"></i> Local Supplier</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['local-suppliers.update', $localSupplier->id],'method'=>'PUT')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group"> 
                <label>Name <span style="color:red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{$localSupplier->name ?? ''}}" placeholder="example" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> 
                <label>Phone <span style="color:red">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{$localSupplier->phone ?? ''}}" placeholder="+880123456789" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> 
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{$localSupplier->email ?? ''}}" placeholder="example@mail.com" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> 
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{$localSupplier->address ?? ''}}" placeholder="Uttara, Dhaka" autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> 
                <label>Pre Due</label>
                <input type="number" name="pre_due" step="any" class="form-control" value="{{$localSupplier->preDue->amount ?? 0}}" placeholder="560005" autocomplete="off">
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer text-right">
          <button class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Update</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
@endsection 