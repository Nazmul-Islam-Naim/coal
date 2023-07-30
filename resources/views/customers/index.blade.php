@extends('layouts.layout')
@section('title', 'Customer')
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
    @if(empty($single_data))
      {!! Form::open(array('route' =>['customer.store'],'method'=>'POST')) !!}
      <?php $btn_name = "Save"; ?>
    @else
      {{  Form::open(array('route' => ['customer.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
      <?php $btn_name = "Update"; ?>
    @endif
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.add') }} {{ __('messages.customer') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>{{ __('messages.customer') }} {{ __('messages.id') }}</label>
                <?php
                  $cusID = DB::table('customer')->orderBy('id', 'desc')->first();
                  if (!empty($cusID->customer_id)) {
                    $id = $cusID->customer_id+1;
                  }else{
                    $id = '1000';
                  }
                ?>
                @if(!empty($single_data->customer_id))
                  <input type="text" name="customer_id" class="form-control" value="{{(!empty($single_data->customer_id))?$single_data->customer_id:''}}" required readonly>
                @else
                  <input type="text" name="customer_id" class="form-control" value="<?php echo $id;?>" required readonly>
                @endif
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{(!empty($single_data->name))?$single_data->name:''}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.company_name') }}</label>
                <input type="text" name="company" class="form-control" value="{{(!empty($single_data->company))?$single_data->company:''}}" autocomplete="off">
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{(!empty($single_data->phone))?$single_data->phone:''}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.address') }}</label>
                <textarea name="address" class="form-control">{{(!empty($single_data->address))?$single_data->address:''}}</textarea>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.customer') }} {{ __('messages.list') }}</h3>
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
                      <th>{{ __('messages.company_name') }}</th>
                      <th>{{ __('messages.phone') }}</th>
                      <th width="15%">{{ __('messages.address') }}</th>
                      <th width="15%">{{ __('messages.pre_due') }}</th>
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
                      <td>{{$data->address}}</td>
                      <td>{{$data->pre_due}}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">Actions <span class="caret"></span></button>
                          <ul class="dropdown-menu" style="border: 2px solid #00a65a;"> 
                            <li><a href="{{ route('customer.edit', $data->id) }}">Edit</a></li>
                            <li>
                                <a href="#addPredue_{{$data->id}}" data-toggle="modal">Add Predue</a>
                                
                                
                            </li>
                            <li class="divider"></li>
                            <li>
                              {{Form::open(array('route'=>['customer.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-sm confirm" title="Delete" style="width: 100%">Delete</button>
                              {!! Form::close() !!}
                            </li>
                          </ul>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="addPredue_{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i> {{ __('messages.pre_due') }} {{ __('messages.add') }}</h5>
                                
                              </div>
                              {{  Form::open(array('route' => ['add-customer-predue',$data->id], 'method' => 'PUT', 'files' => true))  }}
                              <div class="modal-body">
                                    <div class="form-group"> 
                                        <label>{{ __('messages.due') }}</label>
                                        <input type="text" name="pre_due" class="form-control" value="{{$data->pre_due}}" autocomplete="off" required>
                                    </div>
                                    <div class="form-group"> 
                                        <label>{{ __('messages.date') }}</label>
                                        <input type="text" name="pre_due_date" class="form-control datepicker" value="{{$data->pre_due_date}}" autocomplete="off" required>
                                    </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
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
                        <td colspan="8" align="center">
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