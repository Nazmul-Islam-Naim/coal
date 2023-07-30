@extends('layouts.layout')
@section('title', 'Users')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.user') }} {{ __('messages.management') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">User</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    @if(empty($single_data))
      {!! Form::open(array('route' =>['user.store'],'method'=>'POST')) !!}
      <?php $btn_name = "Save"; ?>
    @else
      {{  Form::open(array('route' => ['user.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
      <?php $btn_name = "Update"; ?>
    @endif
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.add') }} {{ __('messages.user') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>{{ __('messages.name') }}</label>
                <input type="text" name="name" class="form-control" value="{{(!empty($single_data->name))?$single_data->name:''}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.email') }}</label>
                <input type="email" name="email" class="form-control" value="{{(!empty($single_data->email))?$single_data->email:''}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.password') }} @if(!empty($single_data))<span style="color: red">(Keep Blank if don't want change)</span>@endif</label>
                <input type="text" name="password" class="form-control" value="">
              </div>
              <div class="form-group">
                @if(Auth::user()->type==1)
                <button type="submit" class="btn btn-success" style="width: 100%"><i class="fa fa-floppy-o"></i> <b>{{$btn_name}} Information</b></button>
                @endif
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.user') }} {{ __('messages.list') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover myTable">   <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.password') }}</th>
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
                      <td>{{$data->name}}</td>
                      <td>{{$data->email}}</td>
                      <td>******</td>
                      <td>
                        <div class="form-inline">
                          <div class="input-group">
                            @if(Auth::user()->type==1)
                            <a href="{{ route('user.edit', $data->id) }}" class="btn btn-primary btn-xs" style="padding: 1px 15px">Edit</a>  
                            @endif
                          </div>
                        </div>
                      </td>
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