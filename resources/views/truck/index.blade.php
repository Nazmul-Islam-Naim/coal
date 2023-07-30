@extends('layouts.layout')
@section('title', 'Truck Management')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Truck Management <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">Truck</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    @if(empty($single_data))
      {!! Form::open(array('route' =>['truck-info.store'],'method'=>'POST')) !!}
      <?php $btn_name = "Save"; ?>
    @else
      {{  Form::open(array('route' => ['truck-info.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
      <?php $btn_name = "Update"; ?>
    @endif
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Add Truck</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>{{ __('messages.name') }} <strong style="color: red">*</strong></label>
                <input type="text" name="name" class="form-control" value="{{(!empty($single_data->name))?$single_data->name:''}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>Number <strong style="color: red">*</strong></label>
                <input type="text" name="number" class="form-control" value="{{(!empty($single_data->number))?$single_data->number:''}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>Price</label>
                <input type="text" name="price" class="form-control" value="{{(!empty($single_data->price))?$single_data->price:''}}" autocomplete="off" required>
              </div>
              <div class="form-group">
                <input type="submit" name="add_truck" class="btn btn-success btn-sm" value="{{$btn_name}} Information">
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Truck Info</h3>
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
                      <th>{{ __('messages.name') }}</th>
                      <th>Number</th>
                      <th>Price</th>
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
                      <!--<td><a href="{{$baseUrl.'/'.config('app.supplier').'/rs-user-ledger/'.$data->id}}" target="_blank">{{$data->name}}</a></td>-->
                      <td>{{$data->name}}</td>
                      <td>{{$data->number}}</td>
                      <td>{{$data->price}}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">Actions <span class="caret"></span></button>
                          <ul class="dropdown-menu" style="border: 2px solid #00a65a;"> 
                            <li><a href="{{ route('truck-info.edit', $data->id) }}">Edit</a></li>
                            <li><a data-toggle="modal" data-target="#myModal_{{$data->id}}" style="cursor: pointer;">Add Rent</a></li>
                            <li class="divider"></li>
                            <!--<li>
                              {{Form::open(array('route'=>['truck-info.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-sm confirm" title="Delete" style="width: 100%">Delete</button>
                              {!! Form::close() !!}
                            </li>-->
                          </ul>
                        </div>
                        
                        <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            {!! Form::open(array('route' =>['truck-info.store'],'method'=>'POST')) !!}
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Rent</h4>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                <div class="col-md-6">
                                <div class="form-group"> 
                                  <label>Truck Number</label>
                                  <input type="text" name="truck_no" class="form-control" value="{{$data->number}}" readonly="">
                                  <input type="hidden" name="truck_id" value="{{$data->id}}">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.branch') }} <strong style="color: red">*</strong></label>
                                  <select class="form-control select2" name="branch_id" required="">
                                    <option value="">--Select--</option>
                                    @foreach($allbranch as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group"> 
                                  <label>Rent Amount <strong style="color: red">*</strong></label>
                                  <input type="text" name="rent_amount" class="form-control" value="" required="">
                                </div>
                                <div class="form-group"> 
                                  <label>Cost Amount <strong style="color: red">*</strong></label>
                                  <input type="text" name="cost_amount" class="form-control" value="" required="">
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group"> 
                                  <label>From <strong style="color: red">*</strong></label>
                                  <input type="text" name="rent_from" class="form-control" value="" required="">
                                </div>
                                <div class="form-group"> 
                                  <label>To <strong style="color: red">*</strong></label>
                                  <input type="text" name="rent_to" class="form-control" value="" required="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.date') }} <strong style="color: red">*</strong></label>
                                  <input type="text" class="form-control detepicker" value="{{date('Y-m-d')}}" name="date" required="">
                                </div>
                                <div class="form-group"> 
                                  <label>{{ __('messages.payment_method') }} <strong style="color: red">*</strong></label>
                                  <select class="form-control select2" name="bank_id" required="">
                                    <option value="">--Select--</option>
                                    @foreach($allbank as $bank)
                                    <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                </div>
                                <div class="col-md-12">
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
                                <input type="submit" name="add_rent" class="btn btn-success btn-sm" value="Add Rent">
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