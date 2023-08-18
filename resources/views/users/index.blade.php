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

    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.user') }} {{ __('messages.list') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{route('user.create')}}" class="btn btn-sm btn-primary float-right"> <i class="fa fa-plus-circle"></i> Add User</a>
            </div>
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
                      <th>{{ __('messages.status') }}</th>
                      <th width="15%">{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach($alldata as $key => $data)
                    <tr> 
                      <td>
                        <label class="label label-success">{{$key+1}}</label>
                      </td>
                      <td>{{$data->name}}</td>
                      <td>{{$data->email}}</td>
                      <td>
                        @if ($data->status == 1)
                            <span class="badge bg-primary badge-sm">Enable</span>
                        @else
                            <span class="badge bg-primary badge-sm">Disable</span>
                        @endif
                      </td>
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
                    @if($alldata->count()==0)
                      <tr>
                        <td colspan="5" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
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