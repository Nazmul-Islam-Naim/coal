@extends('layouts.layout')
@section('title', 'Chalan Invoice')
@section('content')
<?php Session::forget('sellSession')?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Chalan Invoice <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Invoice</li>
  </ol>
</section>
<style type="text/css">
  .SaleTbl > tbody > tr > td{
    border: none;
    padding: 0px;
    font-size: 12px;
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Chalan Invoice</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
              <a href="{{URL::to('sells/product-sell')}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Sell Product</a>          
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
                  <div class="col-md-6">
                  <div class="col-md-12">
                    <center><h3>Chalan Invoice</h3></center>
                  </div>
                  <div class="col-md-12">
                    <table  width="100%" border="0">
                        <tr>			
        			        <td width="100%">
        				<center><img src="images/watermark.png" style="width:80%"></center>
        				<center><h4><b><u> Ship/Boat/Truck Delivary Challan</u></b></h4></center>
        				Invoice #100{{$singleData->id}}<span style="margin-left:40%;">Date: {{$singleData->date}} </span>
        				<br>
        				Buyer Name : {{$singleData->buyer_name}}<br>
        				Address: {{$singleData->address}}<br>
        				From: {{$singleData->chalan_form}} <br>To: {{$singleData->chalan_to}}<br><br>
        				Product : {{$singleData->details}}<br>
        				<table border='1' width="100%">
        					<tr>
        						<td> Truck</td>
        						<td> Length</td>
        						<td> Width</td>
        						<td> Height</td>
        						<td> CFT</td>
        						<td> M.T</td>
        					</tr>
        					<tr>
        						<td> {{$singleData->truck_no}}</td>
        						<td> {{$singleData->length}}</td>
        						<td> {{$singleData->width}}</td>
        						<td> {{$singleData->height}}</td>
        						<td> {{$singleData->cft}}</td>
        						<td> {{$singleData->mt}}</td>
        						
        					</tr>
        				</table>
        				<br>
        				<table width="100%" style="text-align:center; margin-top:50px;">
        					<tr>
        						<td>Buyer Sign</td>
        						<td>Seller Sign</td>
        					</tr>
        				</table>
        				<br><br><br>
        				<center><sup>Not only Product. Quality Product is our goal.</sup></center>
        			
        			</td>
        			        <td></td>
                        </tr>
    
    	            </table>
    			  </div>
    			  </div>
    			  
    			  <div class="col-md-6">
                  <div class="col-md-12">
                    <center><h3>Chalan Invoice</h3></center>
                  </div>
                  <div class="col-md-12">
                    <table  width="100%" border="0">
                        <tr>			
        			        <td width="100%">
        				<center><img src="images/watermark.png" style="width:80%"></center>
        				<center><h4><b><u> Ship/Boat/Truck Delivary Challan</u></b></h4></center>
        				Invoice #100{{$singleData->id}}<span style="margin-left:40%;">Date: {{$singleData->date}} </span>
        				<br>
        				Buyer Name : {{$singleData->buyer_name}}<br>
        				Address: {{$singleData->address}}<br>
        				From: {{$singleData->chalan_form}} <br>To: {{$singleData->chalan_to}}<br><br>
        				Product : {{$singleData->details}}<br>
        				<table border='1' width="100%">
        					<tr>
        						<td> Truck</td>
        						<td> Length</td>
        						<td> Width</td>
        						<td> Height</td>
        						<td> CFT</td>
        						<td> M.T</td>
        					</tr>
        					<tr>
        						<td> {{$singleData->truck_no}}</td>
        						<td> {{$singleData->length}}</td>
        						<td> {{$singleData->width}}</td>
        						<td> {{$singleData->height}}</td>
        						<td> {{$singleData->cft}}</td>
        						<td> {{$singleData->mt}}</td>
        						
        					</tr>
        				</table>
        				<br>
        				<table width="100%" style="text-align:center; margin-top:50px;">
        					<tr>
        						<td>Buyer Sign</td>
        						<td>Seller Sign</td>
        					</tr>
        				</table>
        				<br><br><br>
        				<center><sup>Not only Product. Quality Product is our goal.</sup></center>
        			
        			</td>
        			        <td></td>
                        </tr>
    
    	            </table>
    			  </div>
    			  </div>
    			</div>
    		</div>
		</div>	
	  </div>
	</div>
</div>
</section>
<!-- /.content -->
@endsection 