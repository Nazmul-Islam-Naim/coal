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
      {{  Form::open(array('route' => ['user.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
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
                <label>{{ __('messages.name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{$single_data->name}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.email') }} <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{$single_data->email}}" autocomplete="off" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.password') }}</label>
                <input type="text" name="password" class="form-control" value="">
              </div>
              <div class="form-group"> 
                <label>User Type <span class="text-danger">*</span></label>
                <select name="type_id" class="form-control select2" required>
                  <option value="">select</option>
                  <option value="1" {{($single_data->type == 1) ? 'selected' : ''}}>Super Admin</option>
                  <option value="2" {{($single_data->type == 2) ? 'selected' : ''}}>Admin</option>
                  <option value="3" {{($single_data->type == 3) ? 'selected' : ''}}>User</option>
                </select>
              </div>
              <div class="form-group"> 
                <label>User Status</label>
                <select name="status" class="form-control select2">
                  <option value="1" {{($single_data->status == 1) ? 'selected' : ''}}>Enable</option>
                  <option value="0" {{($single_data->status == 0) ? 'selected' : ''}}>Disable</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success" style="width: 100%"><i class="fa fa-floppy-o"></i> <b>Update</b></button>
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
  </div>
</section>
<!-- /.content -->
@endsection 