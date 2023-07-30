@extends('layouts.layout')
@section('title', 'Update Stock Product')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.stock_product_update') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Stock</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.stock_product') }} {{ __('messages.list') }}</h3>
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
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.quantity') }}</th>
                      <th>{{ __('messages.unit_price') }}</th>
                      <th>{{ __('messages.action') }}</th>
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
                      <td>{{$currentNumber++}}</td>
                      <td>{{$data->stockproduct_product_object->name}}</td>
                      <td>{{$data->quantity}}</td>
                      <td>{{$data->unit_price}}</td>
                      <td> 
                        <a href="#" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal_{{$data->id}}">Update</a>
                      </td>
                      <!-- Modal -->
                      <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">{{ __('messages.edit') }} {{ __('messages.stock_product') }}</h4>
                            </div>
                            {!! Form::open(array('route' =>['update-stock-product.update', $data->id],'method'=>'PUT')) !!}
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="Group Name">{{ __('messages.product') }} {{ __('messages.product') }}</label>
                                    <strong style="color: red">*</strong> :
                                    <input type="text" class="form-control" value="{{$data->stockproduct_product_object->name}}" readonly="" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="Group Name">{{ __('messages.quantity') }}</label>
                                    <strong style="color: red">*</strong> :
                                    <input type="text" class="form-control" name="quantity" value="{{$data->quantity}}" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="Group Name">{{ __('messages.unit_price') }}</label>
                                    <strong style="color: red">*</strong> :
                                    <input type="text" class="form-control" name="unit_price" value="{{$data->unit_price}}" required>
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
                      <!-- ./Modal -->
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="5" align="center">
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