@extends('layouts.layout')
@section('title', 'Bank Account')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.bank_account') }} {{ __('messages.management') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.accounts') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.bank_account') }} {{ __('messages.list') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="javascript:void(0)" class="btn btn-warning btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> <b>{{ __('messages.accounts') }} {{ __('messages.add') }}</b></a>         
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/daily-transaction'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> {{ __('messages.daily_transaction') }}</a>         
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> {{ __('messages.payment_voucher') }}</a>         
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> {{ __('messages.receive_voucher') }}</a>         
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.account_name') }}</th>
                      <th>{{ __('messages.account_no') }}</th>
                      <th>{{ __('messages.account_type') }}</th>
                      <th>{{ __('messages.branch') }}</th>
                      <th>{{ __('messages.balance') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th width="17%">{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                      $ttl = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php $rowCount++; $ttl += $data->balance;?>
                    <tr> 
                      <td>
                        <label class="label label-success">{{$currentNumber++}}</label>
                      </td>
                      <td> 
                        <a href="{{$baseUrl.'/'.config('app.account').'/bank-report/'.$data->id}}">{{$data->bank_name}}</a>
                      </td>
                      <td>{{$data->account_name}}</td>
                      <td>{{$data->account_no}}</td>
                      <td> 
                        <span class="label label-success">{{$data->bankaccount_accounttype_object->name}}</span>
                      </td>
                      <td>{{$data->bank_branch}}</td>
                      <td>{{$data->balance}}</td>
                      <td> 
                        @if($data->status == 1)
                          <span class="label label-success">Active</span>
                        @elseif($data->status == 0)
                          <span class="label label-danger">Inactive</span>
                        @endif
                      </td>
                      <td> 
                        <div class="dropdown">
                          <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Actions <span class="caret"></span></button>
                          <ul class="dropdown-menu" style="border: 2px solid #00a65a;">
                            <?php
                              $baseUrl = URL::to('/');
                            ?>
                            <li><a href="{{$baseUrl.'/'.config('app.account').'/bank-deposit/'.$data->id}}">Deposit</a></li>
                            <li><a href="{{$baseUrl.'/'.config('app.account').'/amount-withdraw/'.$data->id}}">Withdraw</a></li>
                            <li><a href="{{$baseUrl.'/'.config('app.account').'/amount-transfer/'.$data->id}}">Transfer</a></li>
                            <li><a href="{{$baseUrl.'/'.config('app.account').'/bank-report/'.$data->id}}">Report</a></li>
                            <li><a href="#editModal{{$data->id}}" data-toggle="modal">Edit</a></li>
                          </ul>
                        </div>

                        <!-- Start Modal for edit Class -->
                        <div id="editModal{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{ __('messages.edit') }} {{ __('messages.bank_account') }}</h4>
                              </div>

                              {!! Form::open(array('route' =>['bank-account.update', $data->id],'method'=>'PUT')) !!}
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group"> 
                                      <label>{{ __('messages.bank') }} {{ __('messages.name') }}</label>
                                      <input type="text" name="bank_name" class="form-control" value="{{$data->bank_name}}"  autocomplete="off" required>
                                    </div>
                                    <div class="form-group"> 
                                      <label>{{ __('messages.account_name') }}</label>
                                      <input type="text" name="account_name" class="form-control" value="{{$data->account_name}}"  autocomplete="off" required>
                                    </div>
                                    <div class="form-group"> 
                                      <label>{{ __('messages.account_no') }}</label>
                                      <input type="text" name="account_no" class="form-control" value="{{$data->account_no}}"  autocomplete="off" required>
                                    </div>
                                    <div class="form-group"> 
                                      <label>{{ __('messages.account_type') }}</label>
                                      <select class="form-control" name="account_type"> 
                                        <option value="">Select</option>
                                        @foreach($allaccounttype as $type)
                                        <option value="{{$type->id}}" {{($type->id==$data->account_type)? 'selected':''}}>{{$type->name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group"> 
                                      <label>{{ __('messages.branch') }}</label>
                                      <input type="text" name="bank_branch" class="form-control" value="{{$data->bank_branch}}"  autocomplete="off" required>
                                    </div>
                                    <div class="form-group"> 
                                      <label>{{ __('messages.opening_balance') }}</label>
                                      <?php
                                        // getting bank opening balance
                                        $openingBalance = DB::table('transation_report')->where('bank_id', $data->id)->where('reason', 'LIKE', '%' . 'Opening Balance' . '%')->first();
                                      ?>
                                      <input type="hidden" name="bank_balance" class="form-control" value="{{$data->balance}}">
                                      <input type="hidden" name="old_opening_balance" class="form-control" value="{{$openingBalance->amount}}">
                                      <input type="number" name="new_opening_balance" class="form-control" value="{{$openingBalance->amount}}" required>
                                    </div>
                                    <div class="form-group"> 
                                      <label>{{ __('messages.date') }}</label>
                                      <input type="text" name="opening_date" class="form-control datepicker" value="{{$data->opening_date}}"  autocomplete="off" required>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                {{Form::submit('Update',array('class'=>'btn btn-success btn-sm', 'style'=>'width:15%'))}}
                              </div>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                        <!-- End Modal for edit Class -->
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
                    <tr>
                        <td colspan="6"><center><b>{{ __('messages.total') }}</b></center></td>
                        <td>{{Session::get('currency')}} {{number_format($ttl,2)}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                  </tbody>
                </table>
                <div class="col-md-12" align="right">
                  {{ $alldata->render() }}
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

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ __('messages.accounts') }} {{ __('messages.add') }}</h4>
        </div>
        {!! Form::open(array('route' =>['bank-account.store'],'method'=>'POST')) !!}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.bank_name') }}</label>
                <input type="text" name="bank_name" class="form-control" value="" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.account_name') }}</label>
                <input type="text" name="account_name" class="form-control" value="" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Account Number</label>
                <input type="text" name="account_no" class="form-control" value="" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.account_type') }}</label>
                <select class="form-control" name="account_type"> 
                  <option value="">Select</option>
                  @foreach($allaccounttype as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.branch') }}</label>
                <input type="text" name="bank_branch" class="form-control" value="" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.opening_balance') }}</label>
                <input type="number" name="opening_balance" class="form-control" value="" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.date') }}</label>
                <input type="text" name="opening_date" class="form-control datepicker" value="{{date('Y-m-d')}}" autocomplete="off" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          {{Form::submit('Save',array('class'=>'btn btn-success btn-sm', 'style'=>'width:15%'))}}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- ./ Modal -->
</section>
<!-- /.content -->
@endsection 