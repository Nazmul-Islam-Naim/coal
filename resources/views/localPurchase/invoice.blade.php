@extends('layouts.layout')
@section('title', 'Purchase invoice')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Purchase invoice<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Purchase invoice</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i>Purchase invoice</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{route('local-purchases.index')}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Report</a>
            </div>
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;">
                <img class="img-thumbnail" style="width:40px;" src='{{asset("custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">Local Purchase Invoice</h4></center>
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Invoice No</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">invo#{{$localPurchase->id}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Purchase Date</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($localPurchase->date)}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Name</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->name ?? ''}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Phone</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->phone ?? ''}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Email</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->email ?? ''}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Address</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->address ?? ''}}</td>
                    </tr>
                  </thead>
                </table>
                <table style="width: 100%; font-size: 12px; margin-top:15px" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">SL</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Product Type</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Product</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Unit Price</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total</th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach($localPurchase->purchaseDetails as $key => $purchase)
                    <tr>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->product->product_type_object->name ?? ''}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->product->name ?? ''}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->quantity}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->unit_price}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($purchase->quantity * $purchase->unit_price, 2)}}</td>
                    </tr>
                    @endforeach
                    @if($localPurchase->count() == 0)
                      <tr>
                        <td colspan="6" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5" style="text-align: right; border: 1px solid #ddd; padding: 3px 3px">Sub Total ($)</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($localPurchase->amount, 2)}}</td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right"></div>
              </div>
            </div>
            <div class="col-md-12"> 
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