@extends('layouts.layout')
@section('title', 'Product Return Detail')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Product Return Detail<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Product Return Detail</li>
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
    <div class="col-md-12" id="">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Product Return Detail</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{URL::To('product-purchase')}}" class="btn btn-success btn-xs"><i class="fa fa-get-pocket"></i> Purchase Product</a>
            </div>
            <div class="input-group">
              <a href="{{URL::To('purchase-report')}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Purchase Report</a>
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
              <center><h4 style="margin: 0px">Product Return Detail Report</h4></center>
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Supplier Name</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->productreturntosupplier_supplier_object->name}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Supplier ID</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->productreturntosupplier_supplier_object->supplier_id}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Email</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->productreturntosupplier_supplier_object->email}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Phone</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->productreturntosupplier_supplier_object->phone}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Purchase Date</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->return_date}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Invoice</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->tok}}</td>
                    </tr>
                  </thead>
                </table>
                <table style="width: 100%; font-size: 12px; margin-top:15px" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">SL</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Product</th>
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
                      $sumPrice = 0;
                      $sumQnty = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $sumPrice += $data->return_qnty*$data->unit_price;
                        $sumQnty += $data->return_qnty;
                      ?>
                    <tr>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->productreturndetail_product_object->name}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->return_qnty}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$data->unit_price}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->return_qnty*$data->unit_price, 2)}}</td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="5" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4" style="text-align: right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Sub Total</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($sumPrice, 2)}}</b></td>
                    </tr>
                    <tr>
                      <td colspan="4" style="text-align: right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Total Qnty</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($sumQnty, 2)}}</b></td>
                    </tr>
                    <tr>
                      <td colspan="4" style="text-align: right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>(-) Discount</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($singledata->discount, 2)}}</b></td>
                    </tr>
                    <tr>
                      <td colspan="4" style="text-align: right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Grand Total</b></td>
                      
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($sumPrice-$singledata->discount, 2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right"></div>
              </div>
            </div>
            <div class="col-md-12"> 
              <!-- <input type="button" value="Print" onclick="PrintElem('#mydiv')" class="btn-success" /> -->
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
  <?php
    $siteInfo = DB::table('site_setting')->where('id', 1)->first();
    $header = '';
    if (!empty($siteInfo)) {
      $logo = '../public/storage/app/public/uploads/logo/'.$siteInfo->image;
  
      $header = '<td width="20%"><img src="'.$logo.'" width="70px" height="70px"></td><td width="80%"><center><h3 style="margin:0; padding:0; margin-bottom: 0px">'.$siteInfo->company_name.'</h3>'.$siteInfo->address.'<br> Mobile : '.$siteInfo->phone.', Email : '.$siteInfo->email.'</center></td>';
    }
  ?>

  function PrintElem(elem)
  {
    Popup($(elem).html());
  }

  function Popup(data) 
  {   
    var mywindow = window.open('', 'my div', 'height=1000,width=1000');
    var is_chrome = Boolean(mywindow.chrome);
    mywindow.document.write('<html><head><title>Binary IT</title><style>a {text-decoration:none;}</style>');

    var Header = '<?php echo $header;?>';

    mywindow.document.write('<table width="80%" style="margin-left: auto; margin-right: auto"><tr>'+Header+'</tr></table><br>');
    
    mywindow.document.write('</head><body>');
    mywindow.document.write('<center><u><span style="font-weight: bold; font-size: 15px">Purchase Detail Report</span></u><center>');    
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
      
    if (is_chrome) {
      setTimeout(function() { // wait until all resources loaded 
      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10
      mywindow.print(); // change window to winPrint
      mywindow.close(); // change window to winPrint
      }, 500);
    } else {
      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10

      mywindow.print();
      mywindow.close();
    }
    return true;
  }
</script>
@endsection 