@extends('layouts.layout')
@section('title', 'Return Product')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.product_return') }} <small></small> </h1>
  <!--<a href="{{$baseUrl.'/'.config('app.return').'/return-list-from-customer'}}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Customer Return List</a>-->
  <a href="{{$baseUrl.'/'.config('app.return').'/return-list-to-supplier'}}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Supplier Return List</a>
  <a href="{{$baseUrl.'/'.config('app.return').'/wastage-list'}}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Wastage Return List</a>
  <a href="{{$baseUrl.'/'.config('app.product').'/stock-product'}}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Stock Product</a>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Return</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa fa-retweet"></i> {{ __('messages.sell_return_to_supplier') }}</h3>
        </div>
        <!-- /.box-header -->
        <form method="get" action="{{ route('supplier-return') }}">
        {{csrf_field()}}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>{{ __('messages.invoice') }}:</label>
                <input type="text" name="tok" class="form-control" value="" required autocomplete="off">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-sm" style="width: 100%; font-size: 15px"><i class="fa fa-search"></i> Search</button>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        </form>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
@endsection 