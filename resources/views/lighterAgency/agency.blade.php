@extends('layouts.layout')
@section('title', 'Manage Agency')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>{{ __('messages.manage_agency') }}<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.manage_agency') }}</li>
  </ol>
</section>
<style type="text/css">
  .borderless td, .borderless th {
    border: none!important;
  }
</style>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.manage_agency') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="#addModal" class="btn btn-success btn-xs" data-toggle="modal" style="margin-left:1px;"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
            <!--<div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>-->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="printTable">
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.id') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.name') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.owner_name') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.phone') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.email') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.address') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.pre_due') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $predue = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $predue += $data->pre_due;
                      ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        {{$currentNumber++}}
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->agency_id}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.lighter').'/agency-ledger/'.$data->id}}" target="_blank">{{$data->agency_name}}</a></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->owner_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->phone}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->email}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->address}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->pre_due,2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px; display:flex">
                        <a href="#predue{{$data->id}}" data-toggle="modal" class="btn btn-info btn-xs ">Predue</a>
                         <!-- Start Modal for edit Class -->
                         <div id="predue{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Add Pre Due To Agency</h4>
                              </div>

                              {!! Form::open(array('route' =>['add-predue-to-agency', $data->id],'method'=>'PUT')) !!}
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group"> 
                                      <label>Agency ID<span style="color:red">*</span></label>
                                      <input type="number" class="form-control" value="{{$data->agency_id}}" autocomplete="off" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                      <label>Agency {{ __('messages.name') }} <span style="color:red">*</span></label>
                                      <input type="text" class="form-control" value="{{$data->agency_name}}" autocomplete="off" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                      <label>Owner Name<span style="color:red">*</span></label>
                                      <input type="text" class="form-control" value="{{$data->owner_name}}" autocomplete="off" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                      <label>Previous Due<span style="color:red">*</span></label>
                                      <input type="number" name="pre_due" class="form-control" value="{{$data->pre_due}}" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                      <label>Date</label>
                                      <input type="text" name="predue_date" class="form-control datepicker" value="{{!empty($data->predue_date)?$data->predue_date:date('Y-m-d')}}" autocomplete="off" >
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
                        <a href="#editModal{{$data->id}}" class="btn btn-success btn-xs" data-toggle="modal" style="margin-left:1px;">Edit</a>
                          <!-- Start Modal for edit Class -->
                          <div id="editModal{{$data->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-md">
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title"><i class='fa fa-edit'></i> Edit Lighter Agency Information</h4>
                                </div>

                                {!! Form::open(array('route' =>['manage-agency.update', $data->id],'method'=>'PUT')) !!}
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Agency ID <span style="color:red">*</span></label>
                                        <input type="number" name="agency_id" class="form-control" value="{{$data->agency_id}}" autocomplete="off" required readonly>
                                      </div>
                                      <div class="form-group"> 
                                        <label>Agency {{ __('messages.name') }} <span style="color:red">*</span></label>
                                        <input type="text" name="agency_name" class="form-control" value="{{$data->agency_name}}" autocomplete="off" required>
                                      </div>
                                      <div class="form-group"> 
                                        <label>Owner Name <span style="color:red">*</span></label>
                                        <input type="text" name="owner_name" class="form-control" value="{{$data->owner_name}}" autocomplete="off" required>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Phone <span style="color:red">*</span></label>
                                        <input type="number" name="phone" class="form-control" value="{{$data->phone}}" autocomplete="off" required>
                                      </div>
                                      <div class="form-group"> 
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" value="{{$data->email}}" autocomplete="off" >
                                      </div>
                                      <div class="form-group"> 
                                        <label>Address</label>
                                        <textarea name="address" class="form-control" rows="1">{{$data->address}}</textarea>
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
                        {{Form::open(array('route'=>['manage-agency.destroy',$data->id],'method'=>'DELETE'))}}
                        <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-xs confirm" title="Delete" style="margin-left:1px;">Delete</button>
                        {!! Form::close() !!}
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
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="7" style="text-align: center; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($predue, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"></td>
                    </tr>
                  </tfoot>
                </table>
                {{-- <div class="col-md-12" align="right">{{$alldata->render()}}</div> --}}
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
 
  <!-- Start Modal for edit Class -->
  <div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add New Agency Information</h4>
        </div>
        
        {!! Form::open(array('route' =>['manage-agency.store'],'method'=>'POST')) !!}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <?php
              $cusID = DB::table('agencies')->orderBy('id', 'desc')->first();
                if (!empty($cusID->agency_id)) {
                  $id = $cusID->agency_id+1;
                }else{
                  $id = '1000';
                }
              ?>
              <div class="form-group"> 
                <label>Agency ID <span style="color:red">*</span></label>
                <input type="number" name="agency_id" class="form-control" value="{{$id}}" autocomplete="off" required readonly>
              </div>
              <div class="form-group"> 
                <label>Agency {{ __('messages.name') }} <span style="color:red">*</span></label>
                <input type="text" name="agency_name" class="form-control" value="" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>Owner Name <span style="color:red">*</span></label>
                <input type="text" name="owner_name" class="form-control" value="" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Phone <span style="color:red">*</span></label>
                <input type="number" name="phone" class="form-control" value="" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="" autocomplete="off" >
              </div>
              <div class="form-group"> 
                <label>Address</label>
                <textarea name="address" class="form-control" rows="1"></textarea>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          {{Form::submit('Save',array('class'=>'btn btn-success btn-sm', 'style'=>'width:15%'))}}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- End Modal for edit Class -->
</section>
<!-- /.content -->
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
          url: "{{URL::to('find-payment-subtype-with-type-id')}}",
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
                console.log(data);
                $('select[name="payment_sub_type_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
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