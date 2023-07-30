@extends('layouts.layout')
@section('title', 'Product Type')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.product_type') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.type') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.type') }} {{ __('messages.add') }}</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['product-type.store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>{{ __('messages.name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="" autocomplete="off" required>
              </div>
              <div class="form-group">
                {{Form::submit('Save',array('class'=>'btn btn-success', 'style'=>'width:100%'))}}
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        {!! Form::close() !!}
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>

    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.product_type') }} {{ __('messages.list') }}</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.product').'/product-sub-type'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Sub Type</a>
            </div>-->
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.product').'/product-brand'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> {{ __('messages.brand') }}</a>
            </div>-->
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.product').'/product-unit'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Unit</a>
            </div>-->
          </div>
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
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th width="20%">{{ __('messages.action') }}</th>
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
                      <td>{{$data->name}}</td>
                      <td> 
                        <?php
                          if ($data->status == 1) {
                            echo '<span class="label label-success">Active</span>';
                          }elseif ($data->status == 0) {
                            echo '<span class="label label-danger">Inactive</span>';
                          }
                        ?>
                      </td>
                      <td> 
                        <div class="form-inline">
                          <div class = "input-group">
                            <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-primary btn-xs" style="padding: 1px 15px">Edit</a>     
                          </div>
                          <div class = "input-group"> 
                            {{Form::open(array('route'=>['product-type.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                            {!! Form::close() !!}
                          </div>
                        </div>

                        <!-- Start Modal for edit Class -->
                          <div id="editModal{{$data->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title"><i class="fa fa-edit"></i> {{ __('messages.product_type') }} {{ __('messages.edit') }}</h4>
                                </div>

                                {!! Form::open(array('route' =>['product-type.update', $data->id],'method'=>'PUT')) !!}
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="Group Name">{{ __('messages.name') }} <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="{{$data->name}}" name="name" required>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                            {{Form::submit('Update',array('class'=>'btn btn-success btn-sm', 'style'=>'width:25%'))}}
                                        </div>
                                    </div>
                                    </div>
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
                        <td colspan="4" align="center">
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