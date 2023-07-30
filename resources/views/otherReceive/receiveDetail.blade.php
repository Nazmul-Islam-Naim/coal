@extends('layouts.layout')
@section('title', 'Receive Voucher Detials')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Receive Voucher Detials <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report</li>
  </ol>
</section>
<style type="text/css">
  .borderless td, .borderless th {
    border: none!important;
  }
</style>
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          @include('common.message')
          @include('common.commonFunction')
          </div>
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
              <div class="box-header">
                <div class="d-flex justify-content-between">
                  <h3 class="box-title">Receive Voucher Detials</h3>
                  <div class="form-inline pull-right">
                    <div class="input-group">
                      <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="box-body">
                <div class="col-md-6" id="printTable">
                  <div class="col-md-12">
                    <style>
                      #size{
                        margin: 0;
                      }
                      .sl{
                        width:5%;
                        text-align:center;
                      }
                      .dtl{
                        width:70%;
                        text-align:center;
                      }
                      .dtl1{
                        width:70%;
                        text-align:left;
                      }
                      .val{
                        text-align:center;
                      }
                      table {
                        border-collapse: collapse;
                      }
                      table, th, td {
                        border: 1px solid black;
                      }
                      .page {
                        width: 101.6mm;
                        min-height: 142.24mm;
                        padding: 0 auto;
                        margin-left: 5px auto;
                        background: white;     
                      }
                      @page {
                        width: 101.6mm;
                        height: 142.24mm;
                        margin: 0;
                      }
                      @media print {
                        html, body {
                          width: 101.6mm;
                          height: 142.24mm;   
                          background: white;      
                        }
                        .page {
                          margin: 0;
                          border-radius: initial;
                          width: 101.6mm;
                          min-height: 142.24mm;
                          background: white;
                        }
                      }
                    </style>

                    <div class="subpage">
                      <div id="size">
                        <center>
                        শুকরিয়া মার্কেট<br>
                        জিন্দা বাজার, সিলেট<br>
                        ফোনঃ (+৮৮০) ১৭১১৯২১০৮০</center><br>
                            <p style="margin: 0px; text-align: center">রিছিভ ভাউচারের বিস্তারিত তথ্য</p>
                          <table width="100%">
                            <tbody>
                              <tr> 
                                <td>সিঃ নংঃ  {{$single_data->tok}}</td> 
                                <td>তারিখঃ {{dateFormateForView($single_data->receive_date)}}</td>
                              </tr>
                              <tr>
                                <td>
                                  রিছিভ টায়েপঃ {{$single_data->otherreceive_type_object->name}}</td>
                                <td>রিছিভ বিস্তারিতঃ {{$single_data->note}}</td>
                              </tr>
                            </tbody>
                          </table><br>
                          <table width="100%" border="1">
                            <thead>
                              <tr><th class="">সিঃ নংঃ</th><th class="dtl">রিছিভ মেথড </th><th  style="text-align:center">পরিমান </th></tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class="">1</td>
                                <td class="dtl1">{{$single_data->otherreceive_bank_object->bank_name}}</td>
                                <td class="val">{{number_format($single_data->amount, 2)}}</td>
                              </tr>
                              <tr>
                                <td class="" colspan="2" align="center" ><b>সর্বমোট বিল</b></td>
                                <td width="15%" class="val">{{number_format($single_data->amount, 2)}}</td>
                              </tr>
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="col-md-12">
                    <div class="col-md-6" style="float: left;">
                      Bill Maker
                    </div>
                    <div class="col-md-6" style="float: right;">
                      Bill Collector
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <script type="text/javascript">

    function PrintElem2(elem){
      Popup($(elem).html());
    }

    function Popup(data){
      var mywindow = window.open('', 'my div', 'height=595px,width=420px;');
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