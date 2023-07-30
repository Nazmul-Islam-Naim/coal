@extends('layouts.layout')
@section('title', 'Sell Invoice')
@section('content')
<?php Session::forget('sellSession')?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> SELL INVOICE <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> SELL INVOICE</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{URL::to('sells/product-sell')}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-exchange"></i> Sell Product</a>          
            </div>
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="printTable">
              <div class="col-md-12">
                <center><h3>SALE INVOICE</h3></center>
              </div>
              <div class="col-md-8" style="float: left">
                <div class="table-responsive">

                  <table class="table SaleTbl" width="100%" style="margin-left: auto; margin-right: auto;">
                    <br>
                    <span style="padding: 0px 5px 0px 5px;border: 1px solid green;background-color: transparent;">Billing From</span>
                    <tbody>                                   
                      <tr>
                        <td colspan="12">{{$siteInfo->company_name}}</td>
                      </tr>
                      <tr>
                        <td colspan="12">{{$siteInfo->address}}</td>
                      </tr>
                      <tr>
                        <td colspan="12">Mobile: (+88) {{$siteInfo->phone}}</td>
                      </tr>
                      <tr>
                        <td colspan="12">Email: {{$siteInfo->email}}</td>
                      </tr>
                      <tr>
                        <td colspan="12">{{$siteInfo->note}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-4" style="float: right">
                <div class="table-responsive">
                  <span style="padding: 0px 5px 0px 5px;border: 1px solid green;background-color: transparent;">Sale</span>
                  <table class="table SaleTbl" width="100%" style="margin-left: auto; margin-right: auto;">
                    <tbody>                                   
                      <tr>
                        <td colspan="6">Invoice No</td>
                        <td colspan="6">
                          {{$singleData->invoice_no}}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6">Billing Date</td>
                        <td colspan="6">
                          {{$singleData->created_at->format('d-M, Y')}}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6" style="">Created By</td>
                        <td colspan="6">
                          {{$singleData->productsell_user_object->name}}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="12"> 
                          <span style="padding: 0px 5px 0px 5px;border: 1px solid green;background-color: transparent;">Billing To</span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6">Name</td>
                        <td colspan="6">
                          {{$singleData->productsell_customer_object->name}}
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6">Phone</td>
                        <td colspan="6">
                          (+88) {{$singleData->productsell_customer_object->phone}}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">SL</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Item Details</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Truck No</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Unit Price</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $totalPrice = 0;
                      $totalQuantity = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $price = 0;
                        $quantity = 0;
                      ?>
                    <tr>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->productsell_product_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->truck_no}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          echo $quantity = $data->quantity;
                          $totalQuantity += $quantity;
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->unit_price, 2)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          echo number_format($price = $data->quantity*$data->unit_price, 2);
                          $totalPrice += $price;
                        ?>
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="6" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                  
                    <tr>
                      <td colspan="5" style="text-align: right;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Sub Total ({{Session::get('currency')}})</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($totalPrice, 2)}}</b></td>
                    </tr>
                    <tr>
                      <td colspan="5" style="text-align: right;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Total Qnty</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($totalQuantity, 2)}}</b></td>
                    </tr>
                    
                    <tr>
                      <td colspan="5" style="text-align: right;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Grand Total ({{Session::get('currency')}})</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format(($totalPrice+$singleData->total_vat-$singleData->discount), 2)}}</b></td>
                      <?php
                        $totalGrand = ($totalPrice+$singleData->total_vat-$singleData->discount);
                      ?>
                    </tr>
                    <tr>
                      <td colspan="5" style="text-align: right;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Paid Amount ({{Session::get('currency')}})</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($singleData->paid_amount, 2)}}</b></td>
                    </tr>
                    <tr>
                      <td colspan="5" style="text-align: right;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Due Amount ({{Session::get('currency')}})</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($totalGrand-$singleData->paid_amount, 2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right"></div>
              </div>
            </div>
            <!--div class="col-md-12"> 
              <input type="button" value="Print Invoice" onclick="PrintElem('#mydiv')" class="btn-success" style="width: 100%; padding: 15px" />
            </div-->
            
            <div class="col-md-12" style="margin-top: 20px">
                <div class="row">
                    <div class="col-md-6" style="float: left">Customer Signature</div>
                    <div class="col-md-6" style="float: right">Author Signature</div>
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

<script type="text/javascript">
    function PrintElem(elem)
    {
      Popup($(elem).html());
    }

    function Popup(data) 
    {   
      var mywindow = window.open('', 'my div', 'height=1000,width=1000');
      var is_chrome = Boolean(mywindow.chrome);
      mywindow.document.write('<html><head><title>Binary IT</title><style>a {text-decoration:none;}</style>');
      /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    
      mywindow.document.write('</head><body>');
        
      mywindow.document.write(data);
      mywindow.document.write('</body></html>');
      
      if (is_chrome) {
        setTimeout(function() { // wait until all resources loaded 
          mywindow.document.close(); // necessary for IE >= 10
          mywindow.focus(); // necessary for IE >= 10
          mywindow.print(); // change window to winPrint
          mywindow.close(); // change window to winPrint

          //document.location.href = "/smart_restaurant/product-sell";
        }, 500);
      } else {
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();
        //document.location.href = "/smart_restaurant/product-sell";
      }
      return true;
    }
</script>
@endsection 