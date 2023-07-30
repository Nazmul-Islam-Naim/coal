@extends('layouts.layout')
@section('title', 'Customer List')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Customer List To Save Quotation <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Job Card</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Customer List To Save Quotation</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Sell Product</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collection'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus-circle"></i> Bill Collection</a>
            </div>-->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover myTable" width="100%"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>{{ __('messages.id') }}</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>Company</th>
                      <th>{{ __('messages.phone') }}</th>
                      <th width="15%">{{ __('messages.address') }}</th>
                      <th width="15%">{{ __('messages.action') }}</th>
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
                      <?php $rowCount++; ?>
                    <tr> 
                      <td>
                        {{$currentNumber++}}
                      </td>
                      <td>{{$data->customer_id}}</td>
                      <td><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->id}}">{{$data->name}}</a></td>
                      <td>{{$data->company}}</td>
                      <td>{{$data->phone}}</td>
                      <td>{{$data->address}}</td>
                      <td>
                        <a href="{{$baseUrl.'/'.config('app.sell').'/save-job-quotation-form/'.$data->id}}" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus-circle"></i> Create</a>
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="7" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-md-12" align="right">
                  
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