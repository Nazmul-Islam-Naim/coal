@extends('layouts.layout')
@section('title', 'Local Supplier')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Local Suppliers<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.type') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Payment Due Report</h3>
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
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Bill</th>
                      <th>Payment</th>
                      <th>Due</th>
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
                    @foreach($suppliers as $data)
                      <?php $rowCount++; ?>
                    <tr> 
                      <td>
                        <label class="label label-success">{{$currentNumber++}}</label>
                      </td>
                      <td><a href="{{route('local-suppliers.show',$data->id)}}">{{$data->name}}</a></td>
                      <td>{{$data->phone}}</td>
                      <td>{{$data->email}}</td>
                      <td>{{$data->address}}</td>
                      <td>{{$data->bill}}</td>
                      <td>{{$data->payment}}</td>
                      <td>{{$data->due}}</td>
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