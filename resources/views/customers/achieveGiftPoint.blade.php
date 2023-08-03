@extends('layouts.layout')
@section('title', 'Achieve Gift Point')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.achieve_gift_point_report') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">{{ __('messages.gift_point') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">

    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.gift_point') }} {{ __('messages.list') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="printTable">
              <div class="table-responsive">
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.customer') }} {{ __('messages.name') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.phone') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.gift_point') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 250; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                      $totalPoints = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++; 
                        $totalPoints += $data->point;
                      ?>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-ledger/'.$data->customer_id}}">{{$data->giftpoint_customer_object->name}}</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->giftpoint_customer_object->phone}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->point}}</td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="4" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr> 
                      <td colspan="3" style="text-align: center;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{ __('messages.total') }}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{round($totalPoints, 2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                    {{$alldata->render()}}
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