@extends('layouts.layout')
@section('title', 'Product Package')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> PRODUCT PACKAGE MANAGEMENT <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Package</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    {!! Form::open(array('route' =>['product-package.store'],'method'=>'POST', 'files' => true)) !!}
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Create Package</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>Food Type</label>
                <select class="form-control" name="food_type"> 
                  <option value="">Select</option>
                  @foreach($alltype as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>Package Code</label>
                <input type="text" name="package_code" class="form-control" value="" required>
              </div>
              <div class="form-group"> 
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="" required>
              </div>
              <div class="form-group"> 
                <label>Image</label>
                <input type="file" name="image" class="form-control">
              </div>
              <div class="form-group"> 
                <label>Price</label>
                <input type="text" name="price" class="form-control" value="" required>
              </div>
              <div class="form-group"> 
                <label>Details</label>
                <textarea name="details" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success" style="width: 100%"><i class="fa fa-floppy-o"></i> <b>Save Information</b></button>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> PRODUCT PACKAGE LIST</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover"> 
                  <thead> 
                    <tr> 
                      <th>SL</th>
                      <th>Food Type</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th width="20%">Action</th>
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
                      <td>{{$data->productpackage_foodtype_object->name}}</td>
                      <td>{{$data->package_code}}</td>
                      <td>{{$data->name}}</td>
                      <td> 
                        <?php
                          if (!empty($data->image)) {
                            $picture = "public/storage/app/public/uploads/product_package/".$data->image;
                          }else{
                            $picture = "public/custom/img/no_img.png";
                          }
                        ?>
                        <img src="{{asset($picture)}}" height="25px" width="25px">
                      </td>
                      <td>{{$data->price}}</td>
                      <td>
                        <div class="form-inline">
                          <div class="input-group"> 
                            <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-primary btn-xs" style="padding: 1px 15px">Edit</a>    
                          </div>
                          <div class="input-group"> 
                            {{Form::open(array('route'=>['product-package.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete this Wallet ?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                            {!! Form::close() !!}
                          </div>
                        </div>

                        <!-- Start Modal for edit Class -->
                        <div id="editModal{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">EDIT PACKAGE</h4>
                              </div>

                              {!! Form::open(array('route' =>['product-package.update', $data->id],'method'=>'PUT')) !!}
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group"> 
                                      <label>Food Type</label>
                                      <select class="form-control" name="food_type"> 
                                        <option value="">Select</option>
                                        @foreach($alltype as $type)
                                        <option value="{{$type->id}}"{{($type->id==$data->food_type)? 'selected':''}}>{{$type->name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group"> 
                                      <label>Package Code</label>
                                      <input type="text" name="package_code" class="form-control" value="{{$data->package_code}}" required>
                                    </div>
                                    <div class="form-group"> 
                                      <label>Name</label>
                                      <input type="text" name="name" class="form-control" value="{{$data->name}}" required>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group"> 
                                      <label>Price</label>
                                      <input type="text" name="price" class="form-control" value="{{$data->price}}" required>
                                    </div>
                                    <div class="form-group"> 
                                      <label>Details</label>
                                      <textarea name="details" class="form-control">{{$data->details}}</textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div class="col-md-6"> </div>
                                <div class="col-md-6">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100%">Close</button>
                                    </div>
                                    <div class="col-md-6">
                                      {{Form::submit('Update',array('class'=>'btn btn-warning', 'style'=>'width:100%'))}}
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
                        <td colspan="7" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
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
</section>
<!-- /.content -->
@endsection 