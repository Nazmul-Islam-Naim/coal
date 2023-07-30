@extends('layouts.layout')
@section('title', 'Supplier Payment')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.exporter_payment') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.exporter_payment') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.list') }}</h3>
          <!--<div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier-payment-report'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Payment Report</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Accounts</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/daily-transaction'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Daily Transaction</a>
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
                      <!--<th>{{ __('messages.id') }}</th>-->
                      <th>{{ __('messages.name') }}</th>
                      <!--<th>{{ __('messages.company_name') }}</th>-->
                      <th>{{ __('messages.phone') }}</th>
                      <th>{{ __('messages.address') }}</th>
                      <!--<th>{{ __('messages.due') }}</th>-->
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
                      $ttlDue = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php $rowCount++; ?>
                    <tr> 
                      <td>
                        <label class="label label-success">{{$currentNumber++}}</label>
                      </td>
                      <!--<td>{{$data->supplier_id}}</td>-->
                      <td><a href="{{$baseUrl.'/'.config('app.supplier').'/supplier-ledger/'.$data->id}}" target="_blank">{{$data->name}}</a></td>
                      <!--<td>{{$data->company}}</td>-->
                      <td>{{$data->phone}}</td>
                      <td>{{$data->address}}</td>
                      <!--<td>
                        {{Session::get('currency')}}
                        <?php
                          /*$predue = DB::table('supplier_ledger')->where('supplier_id', $data->id)->where('reason', 'like', '%' . 'pre due' . '%')->sum('amount');
                          $billAmount = DB::table('supplier_ledger')->where('supplier_id', $data->id)->where('reason', 'like', '%' . 'purchase' . '%')->sum('amount');

                          $payReturn= DB::table('supplier_ledger')->where('supplier_id', $data->id)->where('reason', 'like', '%' . 'payment(return)' . '%')->sum('amount');
                          $paySupplier= DB::table('supplier_ledger')->where('supplier_id', $data->id)->where('reason', 'like', '%' . 'payment(supplier)' . '%')->sum('amount');
                          $payAdjust= DB::table('supplier_ledger')->where('supplier_id', $data->id)->where('reason', 'like', '%' . 'payment(Adjustment)' . '%')->sum('amount');
                          $dueAmount = ($predue+$billAmount+$payAdjust)-($payReturn+$paySupplier);
                          $ttlDue += $dueAmount;*/
                        ?>
                      </td>-->
                      <td>
                        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal_{{$data->id}}">Payment</a>
                        <!--<a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#adjustModal_{{$data->id}}">Adjust Payment</a>-->
                        <!-- Modal -->
                        <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            {!! Form::open(array('route' =>['product-supplier.store'],'method'=>'POST')) !!}
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{ __('messages.exporter_payment') }}</h4>
                              </div>
                              <div class="modal-body">
                                <div class="form-group"> 
                                  <label>{{ __('messages.name') }}</label>
                                  <input type="text" class="form-control" name="supplier_name" value="{{$data->name}}" readonly="">
                                </div>
                                <!--<div class="form-group"> 
                                  <label>{{ __('messages.due_amount') }} ({{Session::get('currency')}})</label>
                                  
                                  <input type="text" class="form-control" value="" readonly="">
                                </div>-->
                                <div class="form-group"> 
                                  <label>RS {{ __('messages.amount') }} <strong style="color: red">*</strong></label>
                                  <input type="number" step="any" class="form-control" value="" name="pay_amount" required="">
                                  <input type="hidden" value="{{$data->id}}" name="supplier_id">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.payment') }} <strong style="color: red">*</strong></label><br>
                                  <select class="form-control select2" name="rs_id" required="">
                                    <option value="">--Select--</option>
                                    @foreach(\App\Models\RSUser::all() as $bank)
                                    <?php
                                       $bill222=DB::table('rs_rupee_ledger')->where([['reason', 'LIKE', '%add%'],['rs_id',$bank->id]])->sum('amount');
                                       $paid222=DB::table('rs_rupee_ledger')->where([['reason', 'LIKE', '%payment%'],['rs_id',$bank->id]])->sum('amount');
                                    ?>
                                    <option value="{{$bank->id}}">{{$bank->name}} (RS amount : {{$bill222-$paid222}})</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.note') }}</label>
                                  <textarea class="form-control" name="note" rows="1"></textarea>
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.date') }} <strong style="color: red">*</strong></label>
                                  <input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d')?>" name="date" required="" autocomplete="off">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                <input type="submit" name="supplier_payment" class="btn btn-success btn-sm" value="Payment">
                              </div>
                            </div>
                            {!! Form::close() !!}
                          </div>
                        </div>
                        
                        <div id="adjustModal_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            {!! Form::open(array('route' =>['supplier-bill-adjustment'],'method'=>'POST')) !!}
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Adjust Payment</h4>
                              </div>
                              <div class="modal-body">
                                <div class="form-group"> 
                                  <label>{{ __('messages.supplier') }}</label>
                                  <input type="text" class="form-control" name="supplier_name" value="{{$data->name}}" readonly="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.amount') }} <strong style="color: red">*</strong></label>
                                  <input type="number" class="form-control" value="" name="pay_amount" required="">
                                  <input type="hidden" value="{{$data->id}}" name="supplier_id">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.payment') }} <strong style="color: red">*</strong></label><br>
                                  <select class="form-control select2" name="payment_method" required="">
                                    <option value="">--Select--</option>
                                    @foreach(\App\Models\RSUser::all() as $bank)
                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.note') }}</label>
                                  <textarea class="form-control" name="note" rows="1"></textarea>
                                </div>
                                <div class="form-group"> 
                                  <label>Date <strong style="color: red">*</strong></label>
                                  <input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d')?>" name="date" required="" autocomplete="off">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                <input type="submit" name="supplier_payment" class="btn btn-success btn-sm" value="Payment">
                              </div>
                            </div>
                            {!! Form::close() !!}
                          </div>
                        </div>
                        <!-- ./Modal -->
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
                 <!-- <tfoot>
                      <tr>
                        <td colspan="6"><center><b>Total</b></center></td>
                        <td>{{Session::get('currency')}} {{number_format($ttlDue,2)}}</td>
                        <td></td>
                    </tr>
                  </tfoot>-->
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