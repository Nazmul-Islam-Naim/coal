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
      {{  Form::open(array('route' => ['changePassword.Update',Auth::user()->id], 'method' => 'PUT', 'files' => true))  }}
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
                <label>New Password <span class="text-danger">*</span></label>
                <input type="password" value="" name="password" id="newPass" class="keyup" required>
              </div>
              <div class="form-group"> 
                <label>Confirm Password <span class="text-danger">*</span></label>
                <input type="password" value="" name="password_confirmation" id="confirmPass" class="keyup">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success" style="width: 100%"><i class="fa fa-floppy-o"></i> <b>Change Password</b></button>
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