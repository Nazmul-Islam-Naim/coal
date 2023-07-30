@extends('layouts.layout')
@section('title', 'Bill Collection Report')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.bill_collection_amendment') }} <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.bill_collection_amendment') }}</h3>
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
                        <form method="post" action="{{ route('customer-bill-amendment.filter') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
              <div class="table-responsive">
                @if(!empty($start_date) && !empty($end_date))
                  <center><h4>From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
                @else
                  <center><h4>Today : {{date('d-m-Y')}}</h4></center>
                @endif
                <table class="table table-bordered table-striped table-responsive table-hover"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>Sell Date</th>
                      <th>Invoice No</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.phone') }}</th>
                      <th>{{ __('messages.amount') }}</th>
                      <th width="15%">{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 250; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php $rowCount++; ?>
                    <tr> 
                      <td>{{$currentNumber++}}</td>
                      <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                      <td><a href="{{$baseUrl.'/'.config('app.sell').'/sell-invoice/'.$data->tok}}">{{$data->invoice_no}}</a></td>
                      <td><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->customer_id}}">{{$data->ledger_customer_object->name}}</a></td>
                      <td>{{$data->ledger_customer_object->email}}</td>
                      <td>{{$data->ledger_customer_object->phone}}</td>
                      <td> 
                        {{$data->amount}}
                      </td>
                      <td>
                        @if(Auth::user()->type==1)
                        <div class="form-inline">
                          <div class="input-group">
                            <!--<a href="javascript:void(0)" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal_{{$data->id}}">Edit</a>-->
                          </div>
                          <div class="input-group"> 
                            {{Form::open(array('route'=>['customer-bill-amendment.destroy',$data->tok],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                        @endif
                        
                        <!-- Modal -->
                            <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-sm">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Bill Collection</h4>
                                  </div>
                                  {!! Form::open(array('route' =>['edit-bill-collection', $data->tok],'method'=>'PUT')) !!}
                                  <div class="modal-body">
                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Amount</label><br>
                                                <input type="number" name="amount" class="form-control" value="{{$data->amount}}">
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                    {{Form::submit('Update',array('class'=>'btn btn-success btn-sm', 'style'=>'width:25%'))}}
                                  </div>
                                  {!! Form::close() !!}
                                </div>
                            
                              </div>
                            </div>
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
                  {{$alldata->render()}}
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