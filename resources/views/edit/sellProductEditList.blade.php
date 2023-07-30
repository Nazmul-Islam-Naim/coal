@extends('layouts.layout')
@section('title', 'Sell Product')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.sell_product_amendment') }}<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Amendment</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.sell_product_amendment') }}</h3>
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
                        <form method="post" action="{{ route('sell-product-edit.filter') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-inline">
                            <div class="form-group">
                              <label>From : </label>
                              <input type="text" name="start_date" class="form-control datepicker" value="{{date('Y-m-d')}}" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <label>To : </label>
                              <input type="text" name="end_date" class="form-control datepicker" value="{{date('Y-m-d')}}" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <input type="submit" name="search" value="Search" class="btn btn-success btn-md">
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
           
            <div class="col-md-12">
              @if(!empty($start_date) && !empty($end_date))
                <center><h4>From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4>Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover myTable"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>{{ __('messages.date') }}</th>
                      <th>{{ __('messages.invoice') }}</th>
                      <th>{{ __('messages.customer') }}</th>
                      <th>{{ __('messages.discount') }}</th>
                      <th>{{ __('messages.vat') }}</th>
                      <th>Total Bill</th>
                      <th>Total Paid</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                      ?>
                    <tr> 
                      <td>
                        {{$currentNumber++}}
                      </td>
                      <td>{{$data->sell_date}}</td>
                      <td><a href="{{$baseUrl.'/'.config('app.sell').'/sell-invoice/'.$data->tok}}">{{$data->invoice_no}}</a></td>
                      <td><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->customer_id}}">{{$data->productsell_customer_object->name}}</a></td>
                      <td>{{$data->discount}}</td>
                      <td>{{$data->total_vat}}</td>
                      <td>{{$data->sub_total}}</td>
                      <td>{{$data->paid_amount}}</td>
                      <td> 
                        @if(Auth::user()->type==1)
                        <div class="form-inline">
                          <div class = "input-group">
                            <a href="{{$baseUrl.'/'.config('app.amendment').'/sell-product-edit/'.$data->tok.'/edit'}}" class="btn btn-success btn-xs">Edit</a>
                          </div>
                          <div class = "input-group">
                            {{Form::open(array('route'=>['sell-product-edit.destroy',$data->tok],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                        @endif
                      </td>
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
                </table>
                <div class="col-md-12" align="right"></div>
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