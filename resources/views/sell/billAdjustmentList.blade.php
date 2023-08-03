@extends('layouts.layout')
@section('title', 'Bill Adjustment')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Bill Adjustment <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Bill Adjustment</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.sell').'/pos-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> POS Sale</a>    
            </div>-->
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
                        <form method="post" action="{{ route('bill-adjustment.filter') }}">
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
                              <label>Customer/Job Card/Reg. : </label>
                              <input type="text" name="input" class="form-control" value="" autocomplete="off">
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
           
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">Bill Adjustment</h4></center>
              @if(!empty($start_date) && !empty($end_date))
                <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Job No</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Reg. No</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Customer</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Job Card</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total Bill</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total Vat</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Due</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Adjustment</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Discount</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $totalSell = 0;
                      $totalVat = 0;
                      $totalDue = 0;
                      $totalDiscount = 0;
                      $totalAdjustment = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        if($data->total_amount != $data->paid_amount){
                      ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->job_card_date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.sell').'/job-card-invoice/'.$data->tok}}">{{$data->job_card_no}}</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->reg_no}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->customer_id}}">{{$data->productsell_customer_object->name}}</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.sell').'/job-card-invoice/'.$data->tok}}">Job Card</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->total_amount, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->vat_amount, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format(($data->total_amount-($data->paid_amount+$data->discount)), 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->adjustment_amount, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->discount, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal_{{$data->tok}}">Adjust</button>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Discount_{{$data->tok}}">Discount</button>
                        
                        <!-- Adjustment Modal -->
                        <div id="myModal_{{$data->tok}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Adjust Bill #{{$data->job_card_no}}</h4>
                              </div>
                              {!! Form::open(array('route' =>['save-bill-adjustment'],'method'=>'POST')) !!}
                              <div class="modal-body">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" step="any" name="amount" class="form-control" autocomplete="off">
                                    <input type="hidden" value="{{$data->job_card_no}}" name="job_card_no">
                                    <input type="hidden" value="{{$data->customer_id}}" name="customer_id">
                                    <input type="hidden" value="{{$data->tok}}" name="tok">
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control datepicker" autocomplete="off" required="" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select class="form-control" name="bank_id" required="">
                                        @foreach(\App\Models\BankAccount::all() as $bank)
                                        <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                              </div>
                              {!! Form::close() !!}
                            </div>
                        
                          </div>
                        </div>
                        
                        <!-- Discount Modal -->
                        <div id="Discount_{{$data->tok}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Discount Bill #{{$data->job_card_no}}</h4>
                              </div>
                              {!! Form::open(array('route' =>['save-discount-on-bill',$data->tok],'method'=>'PUT')) !!}
                              <div class="modal-body">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" step="any" name="amount" value="{{$data->discount}}" class="form-control" autocomplete="off">
                                    <input type="hidden" value="{{$data->tok}}" name="tok">
                                    <input type="hidden" value="{{$data->job_card_no}}" name="job_card_no">
                                    <input type="hidden" value="{{$data->customer_id}}" name="customer_id">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                              </div>
                              {!! Form::close() !!}
                            </div>
                        
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                      $totalSell += $data->total_amount;
                      $totalVat += $data->vat_amount;
                      $totalAdjustment += $data->adjustment_amount;
                      $totalDiscount += $data->discount;
                      $totalDue += ($data->total_amount-($data->paid_amount+$data->discount));
                    }
                    ?>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="11" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="6" style="text-align: center;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalSell, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalVat, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalDue, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalAdjustment, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalDiscount, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"></td>
                      
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">{{$alldata->render()}}</div>
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