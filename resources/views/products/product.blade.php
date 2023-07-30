@extends('layouts.layout')
@section('title', 'Products')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.product') }} {{ __('messages.management') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.product') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.product') }} {{ __('messages.add') }}</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['product.store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>{{ __('messages.type') }} <span style="color: red">*</span></label>
                <select class="form-control Type select2" name="product_type_id" required=""> 
                  <option value="">Select</option>
                  @foreach($alltype as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>Product Unit <span style="color: red">*</span></label>
                <select class="form-control select2" name="unit_id" required=""> 
                  <option value="">Select</option>
                  @foreach($allunit as $unit)
                  <option value="{{$unit->id}}">{{$unit->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.name') }} <span style="color: red">*</span></label>
                <input type="text" name="name" class="form-control" value="" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.product') }} {{ __('messages.list') }}</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Product Sale</a>
            </div>-->
            <!--<div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.product').'/stock-product'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Stock Product</a>
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
                      <th>{{ __('messages.type') }}</th>
                      <th>{{ __('messages.product_unit') }}</th>
                      <th>{{ __('messages.product_detail') }}</th>
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
                      <td>{{$data->product_type_object->name}}</td>
                      <td> 
                        @if(!empty($data->unit_id))
                        {{$data->product_unit_object->name}}
                        @endif
                      </td>
                      <td>{{$data->description}}</td>
                      <td> 
                        <div class="form-inline">
                          <div class = "input-group">
                            <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-primary btn-xs" style="padding: 1px 9px"><i class="fa fa-pencil"></i></a>     
                          </div>
                          <div class = "input-group"> 
                            {{Form::open(array('route'=>['product.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete this Record ?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;"><i class="fa fa-remove"></i></button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                        <!-- start modal for show barcode -->
                        <div id="barCode{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">SHOW BARCODE</h4>
                              </div>
                              <div class="modal-body">
                                <p>{{$data->bar_code}}</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Start Modal for edit Class -->
                          <div id="editModal{{$data->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title"><i class="fa fa-edit"></i> {{ __('messages.product') }} {{ __('messages.edit') }}</h4>
                                </div>

                                {!! Form::open(array('route' =>['product.update', $data->id],'method'=>'PUT')) !!}
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label for="Group Name">{{ __('messages.product') }} <strong style="color: red">*</strong> </label>
                                        <input type="text" class="form-control" value="{{$data->name}}" name="name" autocomplete="off" required="">
                                      </div>
                                      <div class="form-group">
                                        <label for="Group Name">{{ __('messages.product_type') }}</label>
                                        <select class="form-control Type" name="product_type_id"> 
                                          <option value="">Select</option>
                                          @foreach($alltype as $type)
                                          <option value="{{$type->id}}" <?php echo($type->id==$data->product_type_id)? 'selected':''?>>{{$type->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="Group Name">{{ __('messages.product_unit') }} <strong style="color: red">*</strong> </label>
                                        <select class="form-control" name="unit_id" required=""> 
                                          <option value="">Select</option>
                                          @foreach($allunit as $unit)
                                          <option value="{{$unit->id}}" <?php echo($unit->id==$data->unit_id)? 'selected':''?>>{{$unit->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                        
                                      <div class="form-group"> 
                                        <label>{{ __('messages.product_detail') }}</label>
                                        <textarea name="description" class="form-control">{{$data->description}}</textarea>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                  {{Form::submit('Update',array('class'=>'btn btn-success btn-sm', 'style'=>'width:25%'))}}
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

<?php
  $baseUrl = URL::to('/');
?>

<script type="text/javascript">
  // dependancy dropdown using ajax
  $(document).ready(function() {
    $('.Type').on('change', function() {
      var typeID = $(this).val();
      if(typeID) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          //url: "{{URL::to('find-product-subtype-with-type-id')}}",
          url: "{{$baseUrl.'/'.config('app.product').'/find-product-subtype-with-type-id'}}",
          data: {
            'id' : typeID
          },
          dataType: "json",

          success:function(data) {
            //console.log(data);
            if(data){
              $('.SubType').empty();
              $('.SubType').focus;
              $('.SubType').append('<option value="">Select</option>'); 
              $.each(data, function(key, value){
                //console.log(data);
                $('select[name="product_sub_type_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
              });
            }else{
              $('.SubType').empty();
            }
          }
        });
      }else{
        $('.SubType').empty();
      }
    });
  });
</script>
@endsection 