@extends('layouts.layout')
@section('title', 'Other Receive Voucher')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.receive_voucher_report_amendment') }} <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.receive_voucher_report_amendment') }}</h3>
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
                        <form method="post" action="{{ route('other-receive.filter') }}">
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
              @if(!empty($start_date) && !empty($end_date))
                <center><h4>From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4>Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>{{ __('messages.date') }}</th>
                      <th>{{ __('messages.receive_method') }}</th>
                      <th>{{ __('messages.type') }}</th>
                      <th>{{ __('messages.sub_type') }}</th>
                      <th>{{ __('messages.issue_by') }}</th>
                      <th>{{ __('messages.created_by') }}</th>
                      <th>{{ __('messages.amount') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 250; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $sum = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $sum += $data->amount;
                      ?>
                    <tr> 
                      <td>
                        {{$currentNumber++}}
                      </td>
                      <td>{{dateFormateForView($data->receive_date)}}</td>
                      <td>{{$data->otherreceive_bank_object->bank_name}}</td>
                      <td>{{$data->otherreceive_type_object->name}}</td>
                      <td>{{$data->otherreceive_subtype_object->name}}</td>
                      <td>{{$data->issue_by}}</td>
                      <td>{{$data->otherreceive_user_object->name}}</td>
                      <td>{{$data->amount}}</td>
                      <td>
                        <div class="form-inline">
                          @if(Auth::user()->type==1)
                          <!--<div class="input-group">
                            <a href="javascript:void(0)" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal_{{$data->id}}">Edit</a>
                          </div>-->
                          <div class="input-group">
                            {{Form::open(array('route'=>['other-receive-amenment.destroy',$data->tok],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                            {!! Form::close() !!}
                          </div>
                          @endif
                          
                          <!-- Modal -->
                            <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-sm">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Receive Voucher</h4>
                                  </div>
                                  {!! Form::open(array('route' =>['edit-receive-voucher', $data->tok],'method'=>'PUT')) !!}
                                  <div class="modal-body">
                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Type</label><br>
                                                <input type="text" class="form-control" value="{{$data->otherreceive_type_object->name}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Sub Type</label><br>
                                                <input type="text" class="form-control" value="{{$data->otherreceive_subtype_object->name}}" readonly>
                                            </div>
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
                        <td colspan="9" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="7" style="text-align: center"><b>{{ __('messages.total') }}</b></td>
                      <td><b>{{Session::get('currency')}} {{number_format($sum, 2)}}</b></td><td></td>
                    </tr>
                  </tfoot>
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