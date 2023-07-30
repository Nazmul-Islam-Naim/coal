@extends('layouts.layout')
@section('title', 'Employee')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.employee_info') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.employee_info') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.employee_info') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="javascript:void(0)" class="btn btn-warning btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> <b>ADD EMPLOYEE</b></a>         
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
                      <th>{{ __('messages.image') }}</th>
                      <th>{{ __('messages.id') }}</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.phone') }}</th>
                      <th>{{ __('messages.address') }}</th>
                      <th>{{ __('messages.basic_salary') }}</th>
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
                    ?>
                    @foreach($alldata as $data)
                      <?php $rowCount++; ?>
                    <tr> 
                      <td>
                        <label class="label label-success">{{$currentNumber++}}</label>
                      </td>
                      <td>
                        <?php 
                            if(!empty($data->employee_image)){
                                $img_path = 'storage/app/public/uploads/employees/'.$data->employee_image;
                            }else{
                                $img_path = 'public/custom/img/no_img.png';
                            }
                        ?>
                        <img src="{{asset($img_path)}}" width="40px" height="40px">
                      </td>
                      <td>{{$data->employee_id}}</td>
                      <td><a href="{{$baseUrl.'/'.config('app.employee').'/employee-ledger/'.$data->id}}">{{$data->name}}</a></td>
                      <td>{{$data->email}}</td>
                      <td>{{$data->contact}}</td>
                      <td>{{$data->address}}</td>
                      <td>{{Session::get('currency')}} {{number_format($data->basic_salary,2)}}</td>
                      <td> 
                        <div class="dropdown">
                          <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Actions <span class="caret"></span></button>
                          <ul class="dropdown-menu" style="border: 2px solid #00a65a;">
                            <?php
                              $baseUrl = URL::to('/');
                            ?>
                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#createBill_{{$data->id}}">Create Bill</a></li>
                            <li><a href="{{$baseUrl.'/'.config('app.employee').'/created-bill-list/'.$data->id}}">Bill List</a></li>
                            <li><a href="{{$baseUrl.'/'.config('app.employee').'/employee-ledger/'.$data->id}}">Report</a></li>
                            <li><a href="#editModal{{$data->id}}" data-toggle="modal">Edit</a></li>
                          </ul>
                        </div>
                        
                        <!-- Start Modal for salary -->
                        <div id="createBill_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{ __('messages.Bill_Generate') }}</h4>
                              </div>

                              {!! Form::open(array('route' =>['create-salary-bill'],'method'=>'POST')) !!}
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group"> 
                                        <label>{{ __('messages.name') }}</label>
                                        <input type="text" class="form-control" value="{{$data->name}}" readonly>
                                        <input type="hidden" name="employee_id" value="{{$data->id}}">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group"> 
                                                <label>{{ __('messages.basic_salary') }}</label>
                                                <input type="text" name="basic_amount" class="form-control" id="BasicAmount_{{$data->id}}" value="{{$data->basic_salary}}" readonly>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group"> 
                                                <label>{{ __('messages.Additional_Amount') }}</label>
                                                <input type="number" name="additional_amount" class="form-control" value="" onkeyup="getTotalAmount(this.value, {{$data->id}})" autocomplete="off">
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                     <div class="form-group"> 
                                        <label>{{ __('messages.amount') }}</label>
                                        <input type="number" name="amount" class="form-control" id="TotalAmount_{{$data->id}}" value="{{$data->basic_salary}}" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group"> 
                                                <label>{{ __('messages.Month') }}</label>
                                                <select name="month_name" class="form-control">
                                                @foreach(months() as $value )
                                                <option value="{{$value}}">{{$value}}</option>
                                                @endforeach
                                                </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group"> 
                                                <label>{{ __('messages.Year') }}</label>
                                                <select name="year_name" class="form-control">
                                                @foreach(years() as $value )
                                                <option value="{{$value}}" {{($value==date('Y'))?'selected':''}}>{{$value}}</option>
                                                @endforeach
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group"> 
                                        <label>{{ __('messages.note') }}</label>
                                        <input type="text" name="note" class="form-control" value="" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group"> 
                                        <label>{{ __('messages.date') }}</label>
                                        <input type="text" name="date" class="form-control datepicker" value="{{date('Y-m-d')}}" autocomplete="off">
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
                        <!-- End Modal for salary -->

                        <!-- Start Modal for edit Class -->
                        <div id="editModal{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Edit Employee</h4>
                              </div>

                              {!! Form::open(array('route' =>['employees.update', $data->id],'method'=>'PUT','files'=>true)) !!}
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{$data->name}}" autocomplete="off" required>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" value="{{$data->email}}" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Phone</label>
                                        <input type="text" name="contact" class="form-control" value="{{$data->contact}}" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="{{$data->address}}" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Basic Salary</label>
                                        <input type="text" name="basic_salary" class="form-control" value="{{$data->basic_salary}}" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Joining Date</label>
                                        <input type="text" name="joining_date" class="form-control datepicker" value="{{$data->joining_date}}" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group"> 
                                        <label>Image</label>
                                        <input type="file" name="employee_image" class="form-control" value="" autocomplete="off">
                                        <?php 
                                            if(!empty($data->employee_image)){
                                                $img_path = 'storage/app/public/uploads/employees/'.$data->employee_image;
                                            }else{
                                                $img_path = 'public/custom/img/no_img.png';
                                            }
                                        ?>
                                        <img src="{{asset($img_path)}}" width="100px" height="100px">
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
          <h4 class="modal-title">ADD EMPLOYEE</h4>
        </div>
        {!! Form::open(array('route' =>['employees.store'],'method'=>'POST','files'=>true)) !!}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Employee ID</label>
                <?php
                    $id = DB::table('employees')->latest('id')->take(1)->first();
                    if(!empty($id->employee_id)){
                       $eid = $id->employee_id+1; 
                    }else{
                       $eid = '1000';  
                    }
                ?>
                <input type="text" name="employee_id" class="form-control" value="{{$eid}}" required readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="" autocomplete="off" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Phone</label>
                <input type="text" name="contact" class="form-control" value="" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Basic Salary</label>
                <input type="number" step="any" name="basic_salary" class="form-control" value="" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Joining Date</label>
                <input type="text" name="joining_date" class="form-control datepicker" value="{{date('Y-m-d')}}" autocomplete="off">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>Image</label>
                <input type="file" name="employee_image" class="form-control" value="" autocomplete="off">
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

<script>
function getTotalAmount(value, row){
   var BasicAmount = document.getElementById('BasicAmount_'+row).value;
   var TotalAmnt = parseFloat(value)+parseFloat(BasicAmount);
   document.getElementById('TotalAmount_'+row).value=TotalAmnt;
}
</script>
@endsection 