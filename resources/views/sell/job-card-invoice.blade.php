@extends('layouts.layout')
@section('title', 'JOB CARD')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> JOB CARD <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">JOB CARD</li>
  </ol>
</section>
<style type="text/css">
  .borderless td, .borderless th {
    border: none!important;
  }
	.dot {
	  height: 10px;
	  width: 10px;
	  background-color: #bbb;
	  border-radius: 50%;
	  display: inline-block;
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> JOB CARD</h3>
          <div class="form-inline pull-right">
            <!--<div class="input-group">
                <a href="{{$baseUrl.'/'.config('app.sell').'/pos-sell'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> POS Sale</a>    
            </div>-->
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row" id="printTable">
           
            <div class="col-md-12" >
                <center><h4 style="margin: 0px"><u>JOB CARD</u></h4></center><br>
                
                <div class="container-fluid">
                    <h4>Customer Information </h4>
					<div align="left">
						<table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
						<tbody>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px">Customer ID</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->customer_id}}</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">Job Order No</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->job_card_no}}</td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px">Name</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->name}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px">Receive Date & Time</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->receive_date_time}}</td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px">Phone</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->phone}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px">Delivery Date & Time</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->delivery_date_time}}</td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px">Address</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->address}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px">Brand</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->car_band}}</td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px">Reg No</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->reg_no}}</td>
							

							<td style="border: 1px solid #ddd; padding: 3px 3px">VIN</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->car_vin}}</td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px">Engine</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->car_engine}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px">Odometer</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px">{{$singleData->car_odometer}}</td>
						</tr>
						</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-12">
               <div class="container-fluid">
                   <h4>Service Information</h4>
					<div align="left">
						<table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
							<thead>
								<tr style="background: #ccc;"> 
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Job Code</th>
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Job Instruction/Job Details</th>
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Labour Charge</th>
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Technician</th>
								</tr>
							</thead>
							<tbody>	
							    <?php $sl = 1; $ttl=0;?>
							    @foreach($alldata as $data)
								<tr> 
									<td style="border: 1px solid #ddd; padding: 3px 3px">S{{$sl++}}</td>
									<td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->instruction}}</td>
									<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->cost,2)}}</td>
									<td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->productsellservice_technician_object->name}}</td>
								</tr>
								<?php $ttl+=$data->cost;?>
								@endforeach
					        </tbody>
							<tfoot> 
								<tr> 
									<td colspan="1" style="border: 1px solid #ddd; padding: 3px 3px"></td>
									<td style="border: 1px solid #ddd; padding: 3px 3px"><b>Total</b></td>
									<td style="border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($ttl,2)}}</b></td>
									<td style="border: 1px solid #ddd; padding: 3px 3px"></td>
								</tr>
							</tfoot> 
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-12">
               <div class="container-fluid">
                   <h4>Parts Information</h4>
				    <div align="left">
						<table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
							<thead>
								<tr style="background: #ccc;"> 
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Parts Name</th>
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quanitity</th>
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Unit Price</th>
									<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total</th>
								</tr>
							</thead>
							<tbody>	
							    <?php $sl = 1; $ttl=0;?>
							    @foreach($allproduct as $data)
								<tr> 
									<td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->productsell_product_object->name}}</td>
									<td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->quantity}}</td>
									<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->unit_price,2)}}</td>
									<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->quantity*$data->unit_price,2)}}</td>
								</tr>
								<?php $ttl+=$data->quantity*$data->unit_price;?>
								@endforeach
							</tbody>

							<tfoot> 
								<tr> 
									<td colspan="2" style="border: 1px solid #ddd; padding: 3px 3px"></td>
									<td style="border: 1px solid #ddd; padding: 3px 3px"><b>Total</b></td>
									<td style="border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($ttl,2)}}</b></td>
								</tr>
							</tfoot>
									 
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-12">
               <div class="container-fluid">
                    <h4>Transaction</h4>
	                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
	                   <thead> 
	                       <tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px">Sub Total Bill</td>
                				<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($singleData->total_amount-$singleData->vat_amount,2)}}</td>
                			</tr>
                			
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px">Vat Amont</td>
                				<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($singleData->vat_amount,2)}}</td>
                			</tr>
                			
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px"><b>Grand Total Bill</b></td>
                				<td style="border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($singleData->total_amount,2)}}</b></td>
                			</tr>
                			
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px">Advance</td>
                				<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($singleData->advance,2)}}</td>
                			</tr>
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px">Next Payment</td>

                				<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($singleData->next_payment,2)}}</td>
                			</tr>
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px">Adjustment Amount</td>
                				<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($singleData->adjustment_amount,2)}}</td>
                			</tr>
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px">Discount Amount</td>
                				<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($singleData->discount,2)}}</td>
                			</tr>
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px">Total Paid</td>

                				<td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($singleData->paid_amount-$singleData->adjustment_amount,2)}}</td>
                			</tr>
                			<tr> 
                				<td style="border: 1px solid #ddd; padding: 3px 3px"><b>Due</b></td>
                				<td style="border: 1px solid #ddd; padding: 3px 3px"> 
                					<b>{{number_format($singleData->total_amount-($singleData->paid_amount+$singleData->discount),2)}}</b>
                				</td>
                			</tr>
                		</thead>
                	</table>
			    </div>
		    </div>

			<!--<br>
			<div class="col-md-12">
				<div style="text-align:center">
				  <span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot">
				  
				</div>
			</div>-->

			<div class="col-md-12">
                <div class="container-fluid">
                    <center><h4>Gate Pass</h4></center>
					<div align="left">
						<table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
						<tbody>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Name</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">{{$singleData->name}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Date</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%"></td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Job Order No</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">{{$singleData->job_card_no}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Time</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%"></td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Reg No</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">{{$singleData->reg_no}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Payment Information</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%"></td>
						</tr>
						<tr>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Bill Amount</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">{{number_format($singleData->total_amount,2)}}</td>

							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%">Authority Signature</td>
							<td style="border: 1px solid #ddd; padding: 3px 3px; width: 25%"></td>
						</tr>
						</tbody>
					    </table>
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