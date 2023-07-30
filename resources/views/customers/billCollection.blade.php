@extends('layouts.layout')
@section('title', 'Customer Bill Collection')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.customer') }} {{ __('messages.management') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.customer') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.customer') }} {{ __('messages.list') }}</h3>
          <!--<div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Sell Product</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collection-report'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Bill Collection Report</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Accounts</a>
            </div>
          </div>-->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover myTable"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>{{ __('messages.id') }}</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.phone') }}</th>
                      <th width="15%">{{ __('messages.due') }}</th>
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
                        <label class="label label-success">{{$currentNumber++}}</label>
                      </td>
                      <td>{{$data->customer_id}}</td>
                      <td><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->id}}">{{$data->name}}</a></td>
                      <td>{{$data->company}}</td>
                      <td>{{$data->phone}}</td>
                      <td> 
                        <?php
                          $billAmount = DB::table('customer_ledger')->where('customer_id', $data->id)->where('reason', 'like', '%' . 'sell' . '%')->sum('amount');

                          $payAmount = DB::table('customer_ledger')->where('customer_id', $data->id)->where('reason', 'like', '%' . 'receive' . '%')->sum('amount');
                          $dueAmount = ($data->pre_due+$billAmount) - $payAmount;
                          echo number_format($dueAmount,2);
                        ?>
                      </td>
                      <td>
                        <a data-toggle="modal" data-target="#myModal_{{$data->id}}" class="btn btn-warning btn-xs"><i class="fa fa-plus-circle"></i> Collect Bill</a>
                      </td>
                      <!-- Modal -->
                      <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          {!! Form::open(array('route' =>['customer-bill-collection.store'],'method'=>'POST')) !!}
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">{{ __('messages.bill_collection') }}</h4>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.name') }}</label>
                                <input type="text" class="form-control" value="{{$data->name}}" readonly="">
                                <input type="hidden" name="customer_id" class="form-control" value="{{$data->id}}">
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.customer') }} {{ __('messages.id') }}</label>
                                <input type="text" class="form-control" value="{{$data->customer_id}}" readonly="">
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.phone') }}</label>
                                <input type="text" class="form-control" value="{{$data->phone}}" readonly="">
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.due_amount') }}</label>
                                <input type="text" class="form-control" value="{{$dueAmount}}" readonly="">
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.amount') }} <strong style="color: red">*</strong></label>
                                <input type="text" name="paid_amount" class="form-control" required="">
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.date') }} <strong style="color: red">*</strong></label>
                                <input type="text" name="collect_date" class="form-control datepicker" required="" value="<?php echo date('Y-m-d');?>">
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.payment_method') }} <strong style="color: red">*</strong></label><br>
                                <select class="form-control select2" name="payment_method" required="">
                                  <option value="">--Select--</option>
                                  @foreach($allbank as $bank)
                                  <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                  @endforeach
                                </select>
                              </div>
                              </div>
                              <div class="col-md-6">
                              <div class="form-group">
                                <label>{{ __('messages.note') }} <strong style="color: red">*</strong></label>
                                <textarea name="note" class="form-control" rows="1"></textarea>
                              </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-success btn-sm">Save</button>
                            </div>
                          </div>
                          {!! Form::close() !!}
                        </div>
                      </div>
                      <!-- ./Modal -->
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