@extends('layouts.layout')
@section('title', 'Purchase Report')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>  Local Purchase Report <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Local Purchase Report</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{route('local-purchases.create')}}" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Purchase Now</a>
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
                        <form method="get" action="{{ route('local-purchases.index') }}">
                          <div class="form-inline">
                            <div class="form-group">
                              <label>From : </label>
                              <input type="text" name="start_date" class="form-control datepicker" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <label>To : </label>
                              <input type="text" name="end_date" class="form-control datepicker" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <select name="supplier_id" class="form-control select2">
                                <option value="">Select supplier</option>
                                @foreach($localSuppliers as $localSupplier)
                                <option value="{{$localSupplier->id}}">
                                  {{$localSupplier->name}}
                                </option>
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
           
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px"> Local Purchase Report</h4></center>
              @if(!empty($start_date) && !empty($end_date))
                <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Supplier Name</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.invoice') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Note</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Price</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach($localPurchases as $key => $data)
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        {{$key+1}}
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->supplier->name ?? ''}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{route('local-purchases.show',$data->id)}}">Invo#{{$data->id}}</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->amount, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        @if(Auth::user()->type==1)
                        <div class="form-inline">
                          <div class="input-group">
                            <a href="{{route('local-purchases.edit', $data->id)}}" class="btn btn-info btn-xs" class="btn btn-sm btn-primary">Edit</a>
                          </div>
                          <div class="input-group"> 
                            {{Form::open(array('route'=>['local-purchases.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                        @endif  
                      </td>
                    </tr>
                    @endforeach
                    @if($localPurchases->count() == 0)
                      <tr>
                        <td colspan="7" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="6" style="text-align: center;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($localPurchases->sum('amount'), 2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">{{$localPurchases->render()}}</div>
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