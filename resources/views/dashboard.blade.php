@extends('layouts.layout')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<style>
.custom{
  color: black;
  display: flex;
  border: 1px solid aliceblue;
  border-radius: 2px;
}
.small-box:hover {
  text-decoration: none;
  color: #4abef4;
}
</style>
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
          <label for="Quick Links">Quick Links:</label>
          <a href="{{route('product-sell.index')}}" target="_blank" class="badge badge-pill btn-primary">Sell Product</a>
          <a href="{{route('lc.create')}}" target="_blank" class="badge badge-pill btn-secondary">Create LC</a>
          <a href="{{route('local-purchases.create')}}" target="_blank" class="badge badge-pill btn-success">Local Purchase</a>
          <a href="{{route('distribute-to-branch.index')}}" target="_blank" class="badge badge-pill btn-light">Distribute to Branch</a>
          <a href="{{route('branch-stock.index')}}" target="_blank" class="badge badge-pill btn-danger">Branch Stock</a>
          <a href="{{route('chalan.create')}}" target="_blank" class="badge badge-pill btn-warning">Create Chalan</a>
          <a href="{{route('daily-transaction.index')}}" target="_blank" class="badge badge-pill btn-light">Daily Transaction</a>
          <a href="{{route('payable-suppliers')}}" target="_blank" class="badge badge-pill btn-info">Local Supplier</a>
        </div>
      </div>
    </div>
      <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body"> 
              <div class="row">
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.bm').'/branches'}}" style="color: #ffffff">
                      <?php
                          $ttlBranch = DB::table('branchs')->count();
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/fire.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlBranch}}</h3>
                          <p>Total Branch</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.customer').'/customer'}}" style="color: #ffffff">
                      <?php
                          $ttlCustomer = DB::table('customer')->count();
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/designation.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlCustomer}}</h3>
                          <p>Total Customer</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.sm').'/stock-product'}}" style="color: #ffffff">
                      <?php
                          $ttlMainStock = DB::table('stock_product')->where('branch_id', '0')->sum('quantity');
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/designation.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlMainStock}}</h3>
                          <p>Main Stock</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.sm').'/branch-stock'}}" style="color: #ffffff">
                      <?php
                          $ttlBranchStock = DB::table('stock_product')->where('branch_id', '!=', '0')->sum('quantity');
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/fire.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlBranchStock}}</h3>
                          <p>Branch Stock</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}" style="color: #ffffff">
                      <?php
                          $ttlBill = DB::table('customer_ledger')->where('reason', 'like', '%pre due%')->orWhere('reason', 'like', '%sell%')->sum('amount');
                          $ttlpaid = DB::table('customer_ledger')->where('reason', 'like', '%receive%')->sum('amount');
                          $due=$ttlBill-$ttlpaid;
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/fire.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($due,2)}}</h3>
                          <p>Customer Due</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.sm').'/stock-product'}}" style="color: #ffffff">
                      <?php
                          $ttlMainStock = DB::table('stock_product')->where('branch_id', '0')->sum('quantity');
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/designation.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlMainStock}}</h3>
                          <p>Main Stock</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.sm').'/branch-stock'}}" style="color: #ffffff">
                      <?php
                          $ttlBranchStock = DB::table('stock_product')->where('branch_id', '!=', '0')->sum('quantity');
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/fire.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlBranchStock}}</h3>
                          <p>Branch Stock</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}" style="color: #ffffff">
                      <?php
                          $ttlBill = DB::table('customer_ledger')->where('reason', 'like', '%pre due%')->orWhere('reason', 'like', '%sell%')->sum('amount');
                          $ttlpaid = DB::table('customer_ledger')->where('reason', 'like', '%receive%')->sum('amount');
                          $due=$ttlBill-$ttlpaid;
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/fire.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($due,2)}}</h3>
                          <p>Customer Due</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}" style="color: #ffffff">
                      <?php
                          $ttlBill = DB::table('customer_ledger')->where('reason', 'like', '%pre due%')->orWhere('reason', 'like', '%sell%')->sum('amount');
                          $ttlpaid = DB::table('customer_ledger')->where('reason', 'like', '%receive%')->sum('amount');
                          $due=$ttlBill-$ttlpaid;
                      ?>
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/fire.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($due,2)}}</h3>
                          <p>Customer Due</p>
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