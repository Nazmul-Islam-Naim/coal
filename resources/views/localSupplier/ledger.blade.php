@extends('layouts.layout')
@section('title', 'Supplier Ledger')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.supplier_ledger') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.supplier_ledger') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.supplier_ledger') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin:0">{{ __('messages.supplier_ledger') }}</h4></center>
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Name</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Id</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Sup#{{$localSupplier->id}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Phone</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->phone}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Email</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->email}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Address</td>
                      <td colspan="3" style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->address}}</td>
                    </tr>
                  </thead>
                </table>
                <br>
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.reason') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.bill') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.pay') }}</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.balance') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $credit = 0;
                      $debit = 0;
                      $sum = 0;
                    ?>
                    @foreach($localSupplier->ledger as $data)
                      <?php 
                        $rowCount++;
                      ?>
                    <tr>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <?php
                          $reasons = $data->reason;

                          if(preg_match("/Bill/", $reasons)) {
                            echo number_format($data->amount,2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }elseif(preg_match("/Previous due/", $reasons)) {
                            echo number_format($data->amount,2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <?php
                          $reasons = $data->reason;

                          if(preg_match("/Payment/", $reasons)) {
                            echo number_format($data->amount,2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{Session::get('currency')}} {{number_format($sum,2)}}</td>
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
@endsection 