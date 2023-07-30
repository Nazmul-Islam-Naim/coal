@extends('layouts.layout')
@section('title', 'Site Setting')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.site_setting') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Setting</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-cog"></i> {{ __('messages.site_setting') }}</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['site-setting.update', $alldata->id],'method'=>'PUT','files' => 'true','enctype'=>'multipart/form-data')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"> 
                <label>{{ __('messages.company_name') }}</label>
                <input type="text" name="company_name" class="form-control" value="{{$alldata->company_name}}" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{$alldata->phone}}" >
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.email') }}</label>
                <input type="text" name="email" class="form-control" value="{{$alldata->email}}">
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.address') }}</label>
                <textarea name="address" class="form-control">{{$alldata->address}}</textarea>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.additional_info') }}</label>
                <textarea name="note" class="form-control">{{$alldata->note}}</textarea>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.logo') }}</label><br>
                <?php
                  $logo = 'public/storage/app/public/uploads/logo/'.$alldata->image;
                ?>
                <img src="{{$logo}}" width="50px" height="50px">
                <input type="file" name="image" class="form-control">
              </div>
              <div class="form-group">
                {{Form::submit('Update',array('class'=>'btn btn-success', 'style'=>'width:100%'))}}
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
  </div>
</section>
<!-- /.content -->
@endsection 