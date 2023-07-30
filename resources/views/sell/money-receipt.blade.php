@extends('layouts.layout')
@section('title', 'Money Receipt')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Money Receipt <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Money Receipt</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Money Receipt</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.sell').'/pos-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> POS Sale</a>    
            </div>
            <div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Direct Sale</a>     
            </div>-->
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
           
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px"><u>MONEY RECEIPT</u></h4></center>
              
              <div class="table-responsive">
               	<table class="table" style="border: none; width: 100%">
               		<tbody>
                   		<tr> 
                   			<td width="20%" style="border: none">MR No. :</td>
                   			<td width="30%" style="border: none"></td>
                   		</tr> 
                   		<tr> 
                   			<td width="40%" style="border: none">J/O No. : {{$singleData->job_card_no}}</td>
                   			<td width="30%" style="border: none">Vehicle No. : {{$singleData->reg_no}}</td>
                   			<td width="30%" style="border: none">Date : {{date('d-m-Y',strtotime($singleData->job_card_date))}}</td>
                   		</tr>
               		</tbody>
               	</table>
               	<table class="table" style="border: none">
               		<tbody>
                   		<tr> 
                   			<td width="100%" style="border: none">Received With Thanks From Mr. / Mrs. : __<u>{{$singleData->name}}</u>____</td>
                   		</tr>
                   		<?php $advanceAmount = round($singleData->advance,2);?>
                   		<tr> 
                   			<td width="100%" style="border: none">an amount of TK.  __<u>{{number_format($singleData->advance,2)}}</u>_____ </td>
                   		</tr>
                   		<tr> 
                   			<td width="100%" style="border: none">Vide Cash/Cheque/P.O/Draft No _____________________ Date __<u>{{date('d-m-Y',strtotime($singleData->job_card_date))}}</u>__________________</td>
                   		</tr>
                   		<tr> 
                   			<td width="100%" style="border: none">of ___________________________ Bank ___________________________</td>
                   		</tr>
               		</tbody>
               		<tfoot> 
               			<tr> 
               				<td width="100%" style="border: none; text-align: right">____________________________________________<br> For Jalalabad Auto Care & Servicine Center</td>
               			</tr>
               		</tfoot>
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