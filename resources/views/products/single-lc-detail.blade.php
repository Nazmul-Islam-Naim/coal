@extends('layouts.layout')
@section('title', 'LC Information')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>LC Information<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">LC Information</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        {!! Form::open(array('route' =>['complete-single-lc'],'method'=>'POST')) !!}
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> LC Information</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <!--<div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>-->
                <a href="{{url::to('/purchase/lc')}}" class="btn btn-warning btn-sm"><i class="fa fa-list"></i> LC Information</a>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.LC_No') }} <span class="text-danger">*</span></label>
                <input type="text" name="lc_no" class="form-control" value="{{!empty($single_data->lc_no)?$single_data->lc_no:''}}" autocomplete="off" readonly="">
                <input type="hidden" name="lc_id" value="{{!empty($single_data->id)?$single_data->id:''}}">
                <input type="hidden" name="supplier_id" value="{{!empty($single_data->exporter_id)?$single_data->exporter_id:''}}">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Exporter</label>
                <input type="text" class="form-control" value="{{!empty($single_data->exporter_id)?$single_data->lc_exporter_object->name:''}}" autocomplete="off" readonly="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Origin of Country</label>
                <input type="text" class="form-control" value="{{!empty($single_data->origin_of_country)?$single_data->origin_of_country:''}}" autocomplete="off" readonly="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Quantity</label>
                <input type="text" class="form-control" value="{{!empty($single_data->total_qnty)?$single_data->total_qnty:''}}" autocomplete="off" readonly="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Unit Price ($)</label>
                <input type="text" class="form-control" value="{{!empty($single_data->dollar_rate)?$single_data->dollar_rate:''}}" autocomplete="off" readonly="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Total Price ($)</label>
                <input type="text" class="form-control" id="LCTotalPriceInDollar" value="{{!empty($single_data->sub_total)?$single_data->sub_total:''}}" autocomplete="off" readonly="">
              </div>
              <div class="col-md-12">
              <div class="panel panel-primary">
                <div class="panel-heading">Truck wise product Information</div>
                <div class="panel-body"> 
                  <div class="table-responsive"> 
                  <table class="table"> 
                    <thead> 
                      <tr>
                        <th style="text-align: center">SL</th>
                        <th style="text-align: center">Date</th>
                        <th style="text-align: center">Truck No</th>
                        <th style="text-align: center">Length</th>
                        <th style="text-align: center">Width</th>
                        <th style="text-align: center">Height</th>
                        <th style="text-align: center">Quantity</th>
                        <th style="text-align: center">Per ton($)</th>
                        <th style="text-align: center">Total($)</th>
                        <th style="text-align: center">BDT rate</th>
                        <th style="text-align: center">RS rate</th>
                        <th style="text-align: center">Total RS</th>
                      </tr> 
                    </thead>
                    <?php $row_num = 1; $totalRS=0;$totalQnty=0;$ttlDollar=0;$status=0;?>
                    <tbody class="row_container"> 
                        @if(!empty($allproduct))
                            @foreach($allproduct as $data)
                            <tr id="div_{{$row_num}}">
                                <td style="text-align: center">{{$row_num++}}</td>
                                <td style="text-align: center">{{date('d-m-Y',strtotime($data->date))}}</td>
                                <td style="text-align: center">{{$data->truck_no}}</td>
                                <td style="text-align: center">{{$data->length}}</td>
                                <td style="text-align: center">{{$data->width}}</td>
                                <td style="text-align: center">{{$data->height}}</td>
                                <td style="text-align: center">{{$data->quantity}}</td>
                                <td style="text-align: center">{{number_format($data->unit_price_dollar,2)}}</td>
                                <td style="text-align: center">{{number_format($data->total_dollar,2)}}</td>
                                <td style="text-align: center">{{number_format($data->dollar_rate_bdt,2)}}</td>
                                <td style="text-align: center">{{number_format($data->rupee_rate,2)}}</td>
                                <td style="text-align: center">{{number_format($data->total_rs,2)}}</td>
                            </tr>
                            <?php $row_num++; $totalRS+=$data->total_rs;$totalQnty+=$data->quantity;$ttlDollar+=$data->total_dollar;$status=$data->status;?>
                            @endforeach
                        @endif
                    </tbody> 
                    <tfoot>
                        <tr>
                            <td style="text-align: center" colspan="6"><center>Total</center></td>
                            <td style="text-align: center"><center>{{$totalQnty}}</center></td>
                            <td style="text-align: center"><center></center></td>
                            <td style="text-align: center"><center>{{number_format($ttlDollar,2)}}</center></td>
                            <td style="text-align: center"><center></center></td>
                            <td style="text-align: center"><center></center></td>
                            <td style="text-align: center"><center>{{number_format($totalRS,2)}}</center></td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right"><b>Extra Quantity <span class="text-danger">*</span></b></td>
                            <td>
                                <input type="number" step="any" class="form-control" value="{{$totalQnty-$single_data->total_qnty}}" autocomplete="off" readonly=""  required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right"><b>RS Rate <span class="text-danger">*</span></b></td>
                            <td>
                                <input type="number" step="any" class="form-control" id="RsRate" onkeyup="calculate()" value="" autocomplete="off"  required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right"><b>LC Value <span class="text-danger">*</span></b></td>
                            <td>
                                <input type="hidden" name="already_gotproducts_rs_value" value="{{$totalRS}}" id="GotProductsValue" autocomplete="off"  required>
                                <input type="number" step="any" name="total_lc_value_rs" class="form-control" id="LCValue" value="" autocomplete="off" readonly=""  required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" style="text-align: right"><b>Exporter Bill <span class="text-danger">*</span></b></td>
                            <td>
                                <input type="number" step="any" class="form-control" id="ExporterBill" value="" autocomplete="off" readonly=""  required>
                            </td>
                        </tr>
                    </tfoot>
                  </table>
                  </div>
                </div>
              </div>
              </div>
           </div>
          <!-- /.row -->
        </div>
        <div class="box-footer">
          <div class="form-group">
            @if($status==2)
                Already Completed
            @elseif($status==1)
                <input type="submit" class="btn btn-success btn-sm" value="Complete" onclick="return confirm('Are you sure?')" style="width: 15%; float: right; font-weight: bold">
            @endif
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <!-- /.box -->
    </div>

  </div>
</section>
<!-- /.content -->

<script>
    function calculate(){
        var LCTotalPriceInDollar = $('#LCTotalPriceInDollar').val();
        if(isNaN(parseFloat(LCTotalPriceInDollar))){
            LCTotalPriceInDollar=0;
        }
        var RsRate = $('#RsRate').val();
        if(isNaN(parseFloat(RsRate))){
            RsRate=0;
        }
        
        var ConvertedValue = parseFloat(LCTotalPriceInDollar)*parseFloat(RsRate);
        $('#LCValue').val(ConvertedValue.toFixed(2));
        
        var GotProductsValue = $('#GotProductsValue').val();
        if(isNaN(parseFloat(GotProductsValue))){
            GotProductsValue=0;
        }
        var bill = parseFloat(GotProductsValue)-ConvertedValue;
        $('#ExporterBill').val(bill.toFixed(2));
    }
</script>
@endsection 