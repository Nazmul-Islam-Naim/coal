@extends('layouts.layout')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.dashboard') }} <!--<small>Quick Links</small>--> </h1>

  <!--<a href="{{$baseUrl.'/'.config('app.purchase').'/product-purchase'}}" class="btn btn-success btn-sm"><i class="fa fa-shopping-cart"></i> Product Purchase</a>-->
  <!--<a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" class="btn btn-warning btn-sm"><i class="fa fa-exchange"></i> Sell Product</a>-->
  <!--<a href="{{$baseUrl.'/'.config('app.sell').'/pos-sell'}}" class="btn btn-info btn-sm"><i class="fa fa-exchange"></i> POS Sell</a>-->
  <!--<a href="{{$baseUrl.'/'.config('app.product').'/stock-product'}}" class="btn btn-success btn-sm"><i class="fa fa-product-hunt"></i> Stock Product</a>-->
  <!--<a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-warning btn-sm"><i class="fa fa-bank"></i> Accounts</a>-->
  <!--<a href="{{$baseUrl.'/'.config('app.sell').'/sell-report'}}" class="btn btn-success btn-sm"><i class="fa fa-list"></i> Job Card Report</a>-->
  <!--<a href="{{$baseUrl.'/'.config('app.sell').'/customer-list'}}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Create Job Card</a>-->
  <!--<a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Bill Collection</a>-->
  
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
      <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <center><h2>Coal Management</h2></center>
      <center><u><h3>Quick Links</h3></u></center>   
      <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}" style="color: #ffffff">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Sell Product </b></center></p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.purchase').'/product-purchase'}}" style="color: #ffffff">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Purchase Product </b></center></p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}" style="color: #ffffff">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Bill Collection </b></center></p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier-payment'}}" style="color: #ffffff">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Supplier Payment </b></center></p>
                </div>
              </div>
              </a>
            </div>
        </div>
      <center><u><h3>Reports</h3></u></center>   
      <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.bm').'/branches'}}" style="color: #ffffff">
               <?php
                    $ttlBranch = DB::table('branchs')->count();
               ?>
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Total Branch </b><br><span style="font-size: 25px">{{$ttlBranch}}</span></center></p>
                </div>
              </div>
              </a>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.customer').'/customer'}}" style="color: #ffffff">
                <?php
                    $ttlCustomer = DB::table('customer')->count();
               ?>
              <div class="small-box bg-red">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Total Customer </b><br><span style="font-size: 25px">{{$ttlCustomer}}</span></center></p>
                </div>
              </div>
              </a>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.sm').'/stock-product'}}" style="color: #ffffff">
               <?php
                    $ttlMainStock = DB::table('stock_product')->where('branch_id', '0')->sum('quantity');
               ?>
              <div class="small-box bg-green">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Main Stock </b><br><span style="font-size: 25px">{{$ttlMainStock}}</span></center></p>
                </div>
              </div>
              </a>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.sm').'/branch-stock'}}" style="color: #ffffff">
               <?php
                    $ttlBranchStock = DB::table('stock_product')->where('branch_id', '!=', '0')->sum('quantity');
               ?>
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Branch Stock </b><br><span style="font-size: 25px">{{$ttlBranchStock}}</span></center></p>
                </div>
              </div>
              </a>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}" style="color: #ffffff">
               <?php
                    $ttlBill = DB::table('customer_ledger')->where('reason', 'like', '%pre due%')->orWhere('reason', 'like', '%sell%')->sum('amount');
                    $ttlpaid = DB::table('customer_ledger')->where('reason', 'like', '%receive%')->sum('amount');
                    $due=$ttlBill-$ttlpaid;
               ?>
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 style="font-size: 20px;"></h3>
                  <p><center><b>Customer Due </b><br><span style="font-size: 25px">{{$due}}</span></center></p>
                </div>
              </div>
              </a>
            </div>
      </div>
  
  </div>
            </div>
      </div>
  </div>
</section>
<!-- /.content -->
<script>
  var ctx = document.getElementById("myChart").getContext('2d');
  var graphArr1 = [];
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: '# of Votes',
              data: [ graphArr1[1],graphArr1[2],graphArr1[3],graphArr1[4],graphArr1[5],graphArr1[6],graphArr1[7],graphArr1[8],graphArr1[9],graphArr1[10],graphArr1[11],graphArr1[12] ],
              backgroundColor: [
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35, 1)'
              ],
              borderColor: [
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          tooltips: {
            callbacks: {
              label: function(tooltipItem) {
                  return "Tk " + Number(tooltipItem.yLabel);
              }
            }
          },
          responsive: true,
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          },
          legend: {
              position: 'top',
              display: false
          },
          title: {
              display: false,
              text: 'Chart.js Bar Chart'
          }
      }
  });

  var ctx = document.getElementById("myChart2").getContext('2d');
  var graphArr2 = [];
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: '# of Votes',
              data: [ graphArr2[1],graphArr2[2],graphArr2[3],graphArr2[4],graphArr2[5],graphArr2[6],graphArr2[7],graphArr2[8],graphArr2[9],graphArr2[10],graphArr2[11],graphArr2[12] ],
              backgroundColor: [
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35, 1)'
              ],
              borderColor: [
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35)',
                  'rgba(11, 102, 35, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          tooltips: {
            callbacks: {
              label: function(tooltipItem) {
                  return "Tk " + Number(tooltipItem.yLabel);
              }
            }
          },
          responsive: true,
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          },
          legend: {
              position: 'top',
              display: false
          },
          title: {
              display: false,
              text: 'Chart.js Bar Chart'
          }
      }
  });
</script>
@endsection 