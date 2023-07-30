@extends('layouts.layout')
@section('title', 'LC Wise Add Product')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>LC Wise Add Product<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">LC Wise Add Product</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        {!! Form::open(array('route' =>['save-lc-product'],'method'=>'POST')) !!}
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> LC Wise Add Product</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <!--<div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>-->
                <a href="{{url::to('/purchase/lc')}}" class="btn btn-warning btn-sm"><i class="fa fa-list"></i> {{ __('messages.LC_list') }}</a>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.LC_No') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{!empty($single_data->lc_no)?$single_data->lc_no:''}}" autocomplete="off" readonly="">
                <input type="hidden" name="lc_id" value="{{!empty($single_data->id)?$single_data->id:''}}">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Exporter</label>
                <input type="text" class="form-control" value="{{$single_data->lc_exporter_object->name ?? ''}}" autocomplete="off" readonly="">{{$single_data->exporter_id ?? ''}}
              </div>
              <div class="col-md-4 form-group"> 
                <label>Origin of Country</label>
                <input type="text" class="form-control" value="{{!empty($single_data->origin_of_country)?$single_data->origin_of_country:''}}" autocomplete="off" readonly="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Truck Number</label>
                <input type="text" name="truck_no" class="form-control" value="" autocomplete="off" required="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Height</label>
                <input type="text" name="height" class="form-control" value="" id="Height" onkeyup="calculate()" autocomplete="off" required="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Width</label>
                <input type="text" name="width" class="form-control" value="" id="Width" onkeyup="calculate()" autocomplete="off" required="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Length</label>
                <input type="text" name="length" class="form-control" value="" id="Length" onkeyup="calculate()" autocomplete="off" required="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Converter</label>
                <input type="text" name="converter" class="form-control" value="0.88" id="Converter" onkeyup="calculate()" autocomplete="off" required="">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Quantity</label>
                <input type="text" name="quantity" class="form-control" value="" id="TotalQnty" autocomplete="off" required="">
              </div>
              <div class="col-md-12">
              <div class="panel panel-primary">
                <div class="panel-heading">ADDED PRODUCT DETAILS</div>
                <div class="panel-body"> 
                  <div class="table-responsive"> 
                  <table class="table"> 
                    <thead> 
                      <tr>
                        <th style="text-align: center">{{ __('messages.product_type') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.item_information') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.quantity') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.unit_price') }}  ($)<span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.row_total') }}</th>
                      </tr> 
                    </thead>
                    <?php $row_num = 1; ?>
                    <tbody class="row_container"> 
                        @if(!empty($single_data))
                            @foreach($allproduct as $value)
                            <tr id="div_{{$row_num}}">
                                <td style="text-align: center">{{$value->lc_producttype_object->name}}</td>
                                <td style="text-align: center">{{$value->lc_product_object->name}}</td>
                                <td style="text-align: center">{{$value->quantity}}</td>
                                <td style="text-align: center">{{number_format($value->unit_price,2)}}</td>
                                <td style="text-align: right">{{number_format($value->quantity*$value->unit_price,2)}}</td>
                            </tr>
                            <?php $row_num++; ?>
                            @endforeach
                        @endif
                    </tbody> 
                    <tfoot>
                      <tr>
                        <td colspan="4" style="text-align: right"><b>Unit Price ($)<span class="text-danger">*</span></b></td>
                        <td>
                            <input type="number" step="any" name="unit_price_dollar" class="form-control" id="UnitPrice" onkeyup="calculate()" value="" autocomplete="off"  required>
                        </td>
                      </tr>
                      <tr>
                          <td colspan="4" style="text-align: right"><b>{{ __('messages.total') }} ($)<span class="text-danger">*</span></b></td>
                          <td>
                            <input type="number" step="any" name="total_dollar" class="form-control" id="TotalInDollar" value="" autocomplete="off"  required>
                          </td>
                      </tr>
                      <tr>
                        <td colspan="4" style="text-align: right"><b>{{ __('messages.Dollar_Rate') }} (BDT)<span class="text-danger">*</span></b></td>
                        <td>
                            <input type="number" step="any" name="dollar_rate_bdt" class="form-control" id="DollarRateBDT" onkeyup="calculate()" value="" autocomplete="off"  required>
                        </td>
                      </tr>
                      <tr>
                          <td colspan="4" style="text-align: right"><b>{{ __('messages.total') }} (BDT)<span class="text-danger">*</span></b></td>
                          <td>
                            <input type="number" step="any" name="total_bdt" class="form-control" id="TotalInBDT" value="" autocomplete="off"  required>
                          </td>
                      </tr>
                      <tr>
                        <td colspan="4" style="text-align: right"><b>Rupee Rate<span class="text-danger">*</span></b></td>
                        <td>
                            <input type="number" step="any" name="rupee_rate" class="form-control" id="RupeeRate" onkeyup="calculate()" value="" autocomplete="off"  required>
                        </td>
                      </tr>
                      <tr>
                          <td colspan="4" style="text-align: right"><b>Total RS<span class="text-danger">*</span></b></td>
                          <td>
                            <input type="number" step="any" name="total_rs" class="form-control" id="TotalInRS" value="" autocomplete="off"  required>
                          </td>
                      </tr>
                      
                      <tr>
                          <td colspan="4" style="text-align: right"><b>{{ __('messages.date') }}</b></td>
                          <td> 
                            <input type="text" name="date" class="form-control datepicker" value="" autocomplete="off" >
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
            <input type="submit" class="btn btn-success btn-sm" value="Add Product" onclick="return confirm('Are you sure?')" style="width: 15%; float: right; font-weight: bold">
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
        var Height = $('#Height').val();
        var Width = $('#Width').val();
        var Length = $('#Length').val();
        var Converter = $('#Converter').val();
        if(isNaN(parseFloat(Height))){
            Height=0;
        }
        if(isNaN(parseFloat(Width))){
            Width=0;
        }
        if(isNaN(parseFloat(Length))){
            Length=0;
        }
        if(isNaN(parseFloat(Converter))){
            Converter=0;
        }
        var ConvertedQnty = parseFloat(Height)*parseFloat(Width)*parseFloat(Length)*parseFloat(Converter);
        $('#TotalQnty').val(ConvertedQnty.toFixed(2));
        
        var UnitPrice = $('#UnitPrice').val();
        if(isNaN(parseFloat(UnitPrice))){
            UnitPrice=0;
        }
        var TotalInDollar=ConvertedQnty*parseFloat(UnitPrice);
        $('#TotalInDollar').val(TotalInDollar.toFixed(2));
        
        var DollarRateBDT=$('#DollarRateBDT').val();
        if(isNaN(parseFloat(DollarRateBDT))){
            DollarRateBDT=0;
        }
        var TotalInBDT = parseFloat(TotalInDollar)*parseFloat(DollarRateBDT);
        $('#TotalInBDT').val(TotalInBDT.toFixed(2));
        
        var RupeeRate=$('#RupeeRate').val();
        if(isNaN(parseFloat(RupeeRate))){
            RupeeRate=0;
        }
        var TotalInRS=TotalInDollar*parseFloat(RupeeRate);
        $('#TotalInRS').val(TotalInRS.toFixed(2));
    }
</script>
@endsection 