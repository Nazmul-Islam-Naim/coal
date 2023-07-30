@extends('layouts.layout')
@section('title', 'RS Users')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.rs_user') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.rs_user') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    @if(empty($single_data))
      {!! Form::open(array('route' =>['rs-users.store'],'method'=>'POST')) !!}
      <?php $btn_name = "Save"; ?>
    @else
      {{  Form::open(array('route' => ['rs-users.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
      <?php $btn_name = "Update"; ?>
    @endif
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.rs_user') }} {{ __('messages.add') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <!--<div class="form-group"> 
                <label> {{ __('messages.id') }} <strong style="color: red">*</strong></label>
                <?php
                  /*$cusID = DB::table('supplier')->orderBy('id', 'desc')->first();
                  if (!empty($cusID->supplier_id)) {
                    $id = $cusID->supplier_id+1;
                  }else{
                    $id = '1000';
                  }*/
                ?>
                @if(!empty($single_data->supplier_id))
                  <input type="text" name="supplier_id" class="form-control" value="{{(!empty($single_data->supplier_id))?$single_data->supplier_id:''}}" required readonly>
                @else
                  <input type="text" name="supplier_id" class="form-control" value="<!--?php echo $id;?>" required readonly>
                @endif
              </div>-->
              <div class="form-group"> 
                <label>{{ __('messages.name') }} <strong style="color: red">*</strong></label>
                <input type="text" name="name" class="form-control" value="{{(!empty($single_data->name))?$single_data->name:''}}" autocomplete="off" required>
              </div>
              <!--<div class="form-group"> 
                <label>{{ __('messages.company_name') }}</label>
                <input type="text" name="company" class="form-control" value="{{(!empty($single_data->company))?$single_data->company:''}}" autocomplete="off">
              </div>-->
              <div class="form-group"> 
                <label>{{ __('messages.phone') }} <strong style="color: red">*</strong></label>
                <input type="text" name="phone" class="form-control" value="{{(!empty($single_data->phone))?$single_data->phone:''}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.address') }}</label>
                <textarea name="address" class="form-control">{{(!empty($single_data->address))?$single_data->address:''}}</textarea>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.pre_due') }} </label>
                <input type="text" name="pre_due" class="form-control" value="{{(!empty($single_data->pre_due))?$single_data->pre_due:''}}" autocomplete="off">
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.predue_date') }}</label>
                <input type="text" name="predue_date" class="form-control datepicker" value="{{(!empty($single_data->predue_date))?$single_data->predue_date:''}}" autocomplete="off">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success" style="width: 100%"><i class="fa fa-floppy-o"></i> <b>{{$btn_name}} Information</b></button>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
    {!! Form::close() !!}

    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.rs_user') }} {{ __('messages.list') }}</h3>
          <!--<div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.product').'/product'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Products</a>
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.purchase').'/product-purchase'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Product Purchase</a>
            </div>
          </div>-->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <!--<div class="table-responsive">-->
                <table class="table table-bordered table-striped table-responsive table-hover myTable"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <!--<th>{{ __('messages.id') }}</th>-->
                      <th>{{ __('messages.name') }}</th>
                      <!--<th>Company</th>-->
                      <!--<th>{{ __('messages.phone') }}</th>-->
                      <th>{{ __('messages.address') }}</th>
                      <th>RS (Rupee)</th>
                      <th>Due (BDT)</th>
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
                      <!--<td>{{$data->supplier_id}}</td>-->
                      <td><a href="{{$baseUrl.'/'.config('app.supplier').'/rs-user-ledger/'.$data->id}}" target="_blank">{{$data->name}}</a></td>
                      <!--<td>{{$data->company}}</td>-->
                      <!--<td>{{$data->phone}}</td>-->
                      <td>{{$data->address}}</td>
                      <td>
                          <?php
                           $bill222=DB::table('rs_rupee_ledger')->where([['reason', 'LIKE', '%add%'],['rs_id',$data->id]])->sum('amount');
                           $paid222=DB::table('rs_rupee_ledger')->where([['reason', 'LIKE', '%payment%'],['rs_id',$data->id]])->sum('amount');
                          ?>
                          <a href="{{$baseUrl.'/'.config('app.supplier').'/rs-rupee-ledger/'.$data->id}}" target="_blank">{{number_format($bill222-$paid222,2)}}</a>
                      </td>
                      <td>
                          <?php
                           $bill=DB::table('rs_user_ledger')->where([['reason', 'LIKE', '%pre due%'],['rs_id',$data->id]])->orWhere([['reason', 'LIKE', '%bill for rs added%'],['rs_id',$data->id]])->sum('amount');
                           $paid=DB::table('rs_user_ledger')->where([['reason', 'LIKE', '%payment for rs added%'],['rs_id',$data->id]])->sum('amount');
                          ?>
                          {{number_format($bill-$paid,2)}}
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">Actions <span class="caret"></span></button>
                          <ul class="dropdown-menu" style="border: 2px solid #00a65a;"> 
                            <li><a href="{{ route('rs-users.edit', $data->id) }}">Edit</a></li>
                            <li><a data-toggle="modal" data-target="#myModalRSADD_{{$data->id}}" style="cursor: pointer;">Add RS</a></li>
                            <li><a data-toggle="modal" data-target="#myModal_{{$data->id}}" style="cursor: pointer;">Payment</a></li>
                            <li class="divider"></li>
                            <!--<li>
                              {{Form::open(array('route'=>['rs-users.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-sm confirm" title="Delete" style="width: 100%">Delete</button>
                              {!! Form::close() !!}
                            </li>-->
                          </ul>
                        </div>

                        <!-- Modal -->
                        <div id="myModalRSADD_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            {!! Form::open(array('route' =>['rs-users.store'],'method'=>'POST')) !!}
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{ __('messages.add_rs') }}</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                <div class="col-md-12">
                                <div class="form-group"> 
                                  <label>{{ __('messages.rs_user') }}</label>
                                  <input type="text" class="form-control" value="{{$data->name}}" readonly="">
                                  <input name="rs_id" type="hidden" value="{{$data->id}}">
                                </div>
                                <div class="form-group"> 
                                  <label>RS Amount <strong style="color: red">*</strong></label>
                                  <input type="number" step="any" class="form-control" value="" name="rs_amount" id="Amount_{{$data->id}}" required="" onkeyup="calculator({{$data->id}})">
                                </div>
                                <div class="form-group"> 
                                  <label>RS Rate <strong style="color: red">*</strong></label>
                                  <input type="number" step="any" class="form-control" value="" name="rs_rate" id="Rate_{{$data->id}}" required="" onkeyup="calculator({{$data->id}})">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.amount') }} (BDT) <strong style="color: red">*</strong></label>
                                  <input type="number" step="any" class="form-control" value="" name="total" id="Total_{{$data->id}}" readonly="" required="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.date') }} <strong style="color: red">*</strong></label>
                                  <input type="text" class="form-control detepicker" value="{{date('Y-m-d')}}" name="date" required="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.note') }}</label>
                                  <textarea class="form-control" name="note" rows="1"></textarea>
                                </div>
                                </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div class="row">
                                <div class="col-md-12">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                <input type="submit" name="add_rs" class="btn btn-success btn-sm" value="Add RS">
                                </div>
                                </div>
                              </div>
                            </div>
                            {!! Form::close() !!}
                          </div>
                        </div>
                        
                        <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            {!! Form::open(array('route' =>['rs-users.store'],'method'=>'POST')) !!}
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{ __('messages.payment') }}</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                <div class="col-md-12">
                                <div class="form-group"> 
                                  <label>{{ __('messages.rs_user') }}</label>
                                  <input type="text" name="name" class="form-control" value="{{$data->name}}" readonly="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.due_amount') }}</label>
                                  <input type="text" class="form-control" value="{{$bill-$paid}}" readonly="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.amount') }} <strong style="color: red">*</strong></label>
                                  <input type="number" class="form-control" value="" name="pay_amount" required="">
                                  <input type="hidden" value="{{$data->id}}" name="rs_id">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.payment_method') }} <strong style="color: red">*</strong></label>
                                  <select class="form-control select2" name="payment_method" required="">
                                    <option value="">--Select--</option>
                                    @foreach($allbank as $bank)
                                    <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.date') }} <strong style="color: red">*</strong></label>
                                  <input type="text" class="form-control detepicker" value="{{date('Y-m-d')}}" name="date" required="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.note') }}</label>
                                  <textarea class="form-control" name="note" rows="1"></textarea>
                                </div>
                                </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div class="row">
                                <div class="col-md-12">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                <input type="submit" name="supplier_payment" class="btn btn-success btn-sm" value="Payment">
                                </div>
                                </div>
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
                        <td colspan="6" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-md-12" align="right">
                  
                </div>
              <!--</div>-->
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
<script>
    function calculator(row){
        var X=document.getElementById('Amount_'+row).value;
        var Y=document.getElementById('Rate_'+row).value;
        if(isNaN(parseFloat(X))){
            X=0;
        }
        if(isNaN(parseFloat(Y))){
            Y=0;
        }
        var A=(100/parseFloat(Y));
        var Z=A*parseFloat(X);
        if(isNaN(parseFloat(Z))){
            Z=0;
        }
        document.getElementById('Total_'+row).value=Z.toFixed(2);
    }
</script>
@endsection 