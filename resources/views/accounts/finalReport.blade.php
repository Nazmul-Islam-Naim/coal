@extends('layouts.layout')
@section('title', 'Final Report')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> Final Report <small></small> </h1>
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
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h4 class="box-title"> Final Report</h4>
          <div class="form-inline pull-right">
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body">
          <div class="row">
            <div class="col-md-12"> 
              <div class="table-responsive">
                <table class="table borderless">
                  <tbody>
                    <tr>
                      <td style="text-align: center;">
                        <form method="post" action="{{ route('final-report.filter') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-inline">
                            <div class="form-group">
                              <label>From : </label>
                              <input type="text" name="start_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="form-group">
                              <label>To : </label>
                              <input type="text" name="end_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="form-group">
                              <input type="submit" value="Search" class="btn btn-success btn-md">
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">Final Report</h4></center>
              <div class="table-responsive">
                @if(!empty($start_date) && !empty($end_date))
                  <center><h5 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h5></center>
                @else
                  <center><h5 style="margin: 0px">Today : {{date('d-m-Y')}}</h5></center>
                @endif
                <table class="reportTable" style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">SL</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Particular</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Credit</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Debit</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php 
                      $sum = 0;
                      $totalDebit = 0;
                      $totalCredit = 0;
                      $total = 0;
                    ?>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">1</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier-payment-report'}}">Total Supplier Payment</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($supplier_payment, 2)}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">2</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.sell').'/sell-report'}}">Total Bill Collection</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($total_sell, 2)}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">3</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher-report'}}">Total Adjustment</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($adjustment,2)}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">4</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher-report'}}">Total Other Payment</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($other_payment,2)}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">5</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher-report'}}">Total Other Receive</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($other_receive,2)}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">6</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.employee').'/employee-salary'}}">Total Employee Salary</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($employee_salary,2)}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">7</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}">Banks Opening Balance</a></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($bank_opening_balance,2)}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                    </tr>
                    <tr> 
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">8</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Bank Deposit</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($bank_deposit, 2)}}</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                        </tr>
                        <tr> 
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">9</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Bank Withdraw</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($bank_withdraw, 2)}}</td>
                        </tr>
                        <tr> 
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">10</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Bank Transfer</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($bank_transfer, 2)}}</td>
                        </tr>
                        <tr> 
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">11</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Supplier Bill Adjustment</td>
                          
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{number_format($supplier_bill_adjustment, 2)}}</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">0.00</td>
                        </tr>
                  </tbody>
                  <tfoot> 
                    <?php
                      $totalCredit = $total_sell+$other_receive+$bank_opening_balance+$bank_deposit+$supplier_bill_adjustment;
                      $totalDebit = $supplier_payment+$other_payment+$employee_salary+$bank_withdraw+$bank_transfer+$adjustment;
                      $total = $totalCredit - $totalDebit;
                    ?>
                    <tr> 
                      <td colspan="2" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalCredit,2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($totalDebit,2)}}</b></td>
                    </tr>
                    <tr> 
                      <td colspan="2" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Final Balance</b></center></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($total,2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right"></div>
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