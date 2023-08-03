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
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.bm').'/branches'}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/products.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlBranch}}</h3>
                          <p>Number Of Product</p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.bm').'/branches'}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/branches.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlBranch}}</h3>
                          <p>Number Of Branch</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.customer').'/customer'}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/exporters.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlCustomer}}</h3>
                          <p>Number Of Customer</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('product-importer.index')}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/importers.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlImporters}}</h3>
                          <p>Number Of Importers</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('product-supplier.index')}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/exporters.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlExporters}}</h3>
                          <p>Number Of Exporters</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('local-suppliers.index')}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/importers.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{$ttlLocalSupplirs}}</h3>
                          <p>Number Of Local Supplier</p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('lc-report')}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/lcPurchase.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($ttlLcPurchase,2)}}</h3>
                          <p>LC Purchase <sub>($)</sub></p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('local-purchases.index')}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/products.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($ttlLocalPurchase,2)}}</h3>
                          <p>Local Purchase <sub>(৳)</sub></p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/customerDue.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($customerDue,2)}}</h3>
                          <p>Customer Due <sub>(৳)</sub></p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('sell-report')}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/sellProduct.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($ttlSell,2)}}</h3>
                          <p>Total Sell <sub>(৳)</sub></p>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.sm').'/stock-product'}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/mainStock.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($ttlMainStock,2)}}</h3>
                          <p>Main Stock <sub>(quantity)</sub></p>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{$baseUrl.'/'.config('app.sm').'/branch-stock'}}" target="_blank"  style="color: #ffffff">
                      <div class="small-box bg-white custom">
                        <div class="inner">
                          <img src="{{asset('custom/img/dashboard/branchStock.gif')}}" alt="">
                        </div>
                        <div class="inner">
                          <h3 style="font-size: 20px;">{{number_format($ttlBranchStock,2)}}</h3>
                          <p>Branch Stock <sub>(quantity)</sub></p>
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