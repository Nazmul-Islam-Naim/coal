@extends('layouts.layout')
@section('title', 'Create LC')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>{{ __('messages.Create_LC') }}<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.Create_LC') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        @if(!empty($single_data))
        {!! Form::open(array('route' =>['lc.update',$single_data->id],'method'=>'PUT')) !!}
        <?php $btn='Update';?>
        @else
        {!! Form::open(array('route' =>['lc.store'],'method'=>'POST')) !!}
        <?php $btn='Create';?>
        @endif
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{$btn}} LC</h3>
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
                <input type="text" name="lc_no" class="form-control" value="{{!empty($single_data->lc_no)?$single_data->lc_no:''}}" autocomplete="off" required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.bank') }}<span class="text-danger">*</span></label>
                @if(empty($single_data->bank_id))
                <select name="bank_id" class="form-control" required>
                  <option value="">Select One</option>
                  @foreach($allaccounts as $account)
                  <option value="{{$account->id}}" {{(!empty($single_data->bank_id) && ($single_data->bank_id==$account->id))?'selected':''}}>{{$account->bank_name}}</option>
                  @endforeach
                </select>
                @else
                <select name="bank_id" class="form-control" required disabled>
                  <option value="">Select One</option>
                  @foreach($allaccounts as $account)
                  <option value="{{$account->id}}" {{(!empty($single_data->bank_id) && ($single_data->bank_id==$account->id))?'selected':''}}>{{$account->bank_name}}</option>
                  @endforeach
                </select>
                @endif
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.Importer') }}<span class="text-danger">*</span></label>
                <select name="importer_id" class="form-control" required>
                  <option value="">Select One</option>
                  @foreach($allimporter as $importer)
                  <option value="{{$importer->id}}" {{(!empty($single_data->importer_id) && ($single_data->importer_id==$importer->id))?'selected':''}}>{{$importer->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.Exporter') }}<span class="text-danger">*</span></label>
                <select name="exporter_id" class="form-control" required>
                  <option value="">Select One</option>
                  @foreach($allsupplier as $supplier)
                  <option value="{{$supplier->id}}" {{(!empty($single_data->exporter_id) && ($single_data->exporter_id==$supplier->id))?'selected':''}}>{{$supplier->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.Origin_Of_Country') }}</label>
                <input type="text" name="origin_of_country" class="form-control" value="{{!empty($single_data->origin_of_country)?$single_data->origin_of_country:''}}" autocomplete="off" >
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.Opening_Date') }}<span class="text-danger">*</span></label>
                <input type="text" name="opening_date" class="form-control datepicker" value="{{!empty($single_data->opening_date)?$single_data->opening_date:''}}" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.Expire_Date') }}<span class="text-danger">*</span></label>
                <input type="text" name="expire_date" class="form-control datepicker" value="{{!empty($single_data->expire_date)?$single_data->expire_date:''}}" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.Shipment_Date') }}<span class="text-danger">*</span></label>
                <input type="text" name="shipment_date" class="form-control datepicker" value="{{!empty($single_data->shipment_date)?$single_data->shipment_date:''}}" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>{{ __('messages.Border') }}<span class="text-danger">*</span></label>
                <select name="border_id" class="form-control" required>
                  <option value="">--Select One--</option>
                  @foreach($allborder as $border)
                  <option value="{{$border->id}}" {{(!empty($single_data->border_id) && ($single_data->border_id==$border->id))?'selected':''}}>{{$border->name}}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-12">
              <div class="panel panel-primary">
                <div class="panel-heading">{{ __('messages.add_product_details') }}</div>
                <div class="panel-body"> 
                  <div class="table-responsive"> 
                  <table class="table"> 
                    <thead> 
                      <tr>
                        <th style="text-align: center">{{ __('messages.product_type') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.item_information') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.stock_qnty') }}</th>
                        <th style="text-align: center">{{ __('messages.quantity') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.unit_price') }}  ($)<span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.row_total') }}</th>
                        <th style="text-align: center">{{ __('messages.action') }}</th> 
                      </tr> 
                    </thead>
                    <?php $row_num = 1; ?>
                    <tbody class="row_container"> 
                        @if(!empty($single_data))
                            @foreach($alllcproducts as $value)
                            <tr id="div_{{$row_num}}">
                                <td> 
                                    <select class="form-control allProductTypeList select2" onchange="productTypeId({{$row_num}})" id="productTypeId_{{$row_num}}" name="purchase_details[{{$row_num}}][product_type_id]" required="">
                                        <option value="">--Select--</option>
                                        @foreach($allproducttype as $type)
                                        <option value="{{$type->id}}" {{($type->id==$value->product_type_id)?'selected':''}}>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control allProductList select2" name="purchase_details[{{$row_num}}][product_id]" id="productId_{{$row_num}}" onchange="getProductDetails(this.value, {{$row_num}})" required="">
                                        <option value="">--Select--</option>
                                        @foreach($allproduct as $product)
                                        <option value="{{$product->id}}" {{($product->id==$value->product_id)?'selected':''}}>{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control individualBookStockQnty" id="stockqnty_{{$row_num}}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="purchase_details[{{$row_num}}][quantity]" class="form-control individualBookQnty" id="quantity_{{$row_num}}" onkeyup="multiply({{$row_num}});" value="{{$value->quantity}}" required="" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" name="purchase_details[{{$row_num}}][unit_price]" class="form-control individualBookPrice" id="rate_{{$row_num}}" onkeyup="multiply({{$row_num}});" value="{{$value->unit_price}}" required="" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" name="total[]" class="form-control individualBookTtlPrice" id="Total_{{$row_num}}" value="{{$value->unit_price*$value->quantity}}" readonly>
                                </td>
                                <td>
                                    <a href="javascript:;" class="btn btn-sm btn-danger pull-right" onclick="$('#div_{{$row_num}}').remove();calculate()"><i class="fa fa-remove"></i></a>
                                </td>
                            </tr>
                            <?php $row_num++; ?>
                            @endforeach
                        @endif
                    </tbody> 
                    <tfoot>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>{{ __('messages.row_total') }}  ($)</b></td>
                        <td>
                          <input type="text" name="sub_total" class="form-control bookSubTtlPrice" id="subTotal" value="{{!empty($single_data->sub_total)?$single_data->sub_total:''}}" readonly>
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();"><i class="fa fa-plus"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" style="text-align: right"><b>{{ __('messages.Dollar_Rate') }} (BDT)<span class="text-danger">*</span></b></td>
                        <td>
                            <input type="number" step="any" name="dollar_rate" class="form-control" id="dollarRate" onkeyup="calculate()" value="{{!empty($single_data->dollar_rate)?$single_data->dollar_rate:''}}" autocomplete="off"  required>
                        </td>
                        <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>{{ __('messages.total') }} (BDT)<span class="text-danger">*</span></b></td>
                          <td>
                            <input type="number" step="any" name="total_bdt" class="form-control" id="totalInBDT" onkeyup="calculate()" value="{{!empty($single_data->total_bdt)?$single_data->total_bdt:''}}" autocomplete="off"  required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>{{ __('messages.Margin') }} (%)<span class="text-danger">*</span></b></td>
                          <td>
                            <input type="number" step="any" name="margin_percent" class="form-control" id="marginPercent" onkeyup="calculate()" value="{{!empty($single_data->margin_percent)?$single_data->margin_percent:''}}" autocomplete="off"  required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>{{ __('messages.Margin_Amount') }} (BDT)<span class="text-danger">*</span></b></td>
                          <td> 
                            <input type="number" step="any" name="margin_amount" class="form-control" id="marginAmount" onkeyup="calculate()" value="{{!empty($single_data->margin_amount)?$single_data->margin_amount:''}}" autocomplete="off"  required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>{{ __('messages.Bank_Due') }} ($)<span class="text-danger">*</span></b></td>
                          <td> 
                            <input type="number" step="any" name="bank_due" class="form-control" id="bankDue" onkeyup="calculate()" value="{{!empty($single_data->bank_due)?$single_data->bank_due:''}}" autocomplete="off" readonly required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>{{ __('messages.Commission') }} (BDT)</b></td>
                          <td>
                            <input type="number" step="any" name="commission" class="form-control" id="commission" onkeyup="calculate()" value="{{!empty($single_data->commission)?$single_data->commission:''}}" autocomplete="off">
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>{{ __('messages.Insurance') }} (BDT)</b></td>
                          <td> 
                            <input type="number" step="any" name="insurance" class="form-control" id="insurance" onkeyup="calculate()" value="{{!empty($single_data->insurance)?$single_data->insurance:''}}" autocomplete="off" >
                          </td>
                          <td></td>
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
            <input type="submit" class="btn btn-success btn-sm" value="{{$btn}} LC" onclick="return confirm('Are you sure?')" style="width: 15%; float: right; font-weight: bold">
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <!-- /.box -->
    </div>

  </div>
</section>
<!-- /.content -->
<?php
  $result = "";
  $result2 = "";
  foreach ($allproduct as $value) {
    $result .= '<option value="'.$value["id"].'">'.$value["name"].'</option>';
  }
  
  foreach ($allproducttype as $value) {
    $result2 .= '<option value="'.$value["id"].'">'.$value["name"].'</option>';
  }
?>
<script>
    // dynamic add more field
  var Result = '<?php echo $result;?>';
  var Result2 = '<?php echo $result2;?>';
  var RowNum = '<?php echo $row_num;?>'; 
  function addrow(){  
    if($('#productTypeId').val() == ""){
        alert('At first Select Product Type !');
        $('#productTypeId').click();
        return true;
    }
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html +='<td>'; 
    html +='<select class="form-control allProductTypeList select2" onchange="productTypeId('+RowNum+')" id="productTypeId_'+RowNum+'" name="purchase_details['+RowNum+'][product_type_id]" required=""><option value="">--Select--</option>'+Result2+'</select>'; 
    html +='</td>'; 
    html +='<td>'; 
    html +='<select class="form-control allProductList select2" name="purchase_details['+RowNum+'][product_id]" id="productId_'+RowNum+'" onchange="getProductDetails(this.value, '+RowNum+')" required=""></select>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" class="form-control individualBookStockQnty" id="stockqnty_'+RowNum+'" readonly>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" name="purchase_details['+RowNum+'][quantity]" class="form-control individualBookQnty" id="quantity_'+RowNum+'" onkeyup="multiply('+RowNum+');" required="" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" name="purchase_details['+RowNum+'][unit_price]" class="form-control individualBookPrice" id="rate_'+RowNum+'" onkeyup="multiply('+RowNum+');" required="" autocomplete="off">'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" name="total[]" class="form-control individualBookTtlPrice" id="Total_'+RowNum+'">'; 
    html +='</td>';
    html +='<td>'; 
    html +='<a href="javascript:;" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate()"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
    $(".select2").select2({});
    RowNum++;
  }
  
  // type wise product
    function productTypeId(row){
        var value=$('#productTypeId_'+row).val();
        
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: "{{$baseUrl.'/'.config('app.purchase').'/find-product-details-with-type-id'}}",
          data: {
            'type_id' : value,
          },
          dataType: "json",
          success:function(data) {
                console.log(data);
                $("#productId_"+row).empty();
                $("#stockqnty_"+row).val('');
                $("#quantity_"+row).val('');
                $("#rate_"+row).val('');
                $("#Total_"+row).val('');
                //$(".bookSubTtlPrice").val('');
              
                $("#productId_"+row).append('<option  value="">--Select--</option>');
                $.each(data, function(key, value){
                    console.log(value.name);
                    $("#productId_"+row).append('<option  value='+value.id+'>'+value.name+'</option>');
                });
          }
        });
    }
    
    function getProductDetails(value, RowNums) {
        //alert(value);
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          //url: "{{URL::to('find-product-details-with-id')}}",
          url: "{{$baseUrl.'/'.config('app.sell').'/find-product-details-with-id'}}",
          data: {
            'id' : value
          },
          dataType: "json",
          success:function(data) {
            //$('#rate_'+RowNums).val(data.price);
            //$('#vatpercent_'+RowNums).val(data.vat_percent);
            $('#stockqnty_'+RowNums).val(data.quantity);
          }
        });
    }
    
    function multiply(RowNum){
        var qnty = document.getElementById('quantity_'+RowNum).value;
        var rate = document.getElementById('rate_'+RowNum).value;
        var total = parseFloat(qnty)*parseFloat(rate);
    
        if (isNaN(total)) {
          document.getElementById('Total_'+RowNum).value = 0;
        }else{
          document.getElementById('Total_'+RowNum).value = total.toFixed(2);
        }
    
        // summation of total in total field
    
        var arr = document.getElementsByName('total[]');
        RowNum++;
        var tot=0;
          for(var i=0;i<arr.length;i++){
              if(parseFloat(arr[i].value))
                  tot += parseFloat(arr[i].value);
          }
          document.getElementById('subTotal').value = tot.toFixed(2);
    }
    
    function calculate(){
        var subTotal = $('#subTotal').val();
        var dollarRate = $('#dollarRate').val();
        var totalInBDT = $('#totalInBDT').val();
        var marginPercent = $('#marginPercent').val();
        var marginAmount = $('#marginAmount').val();
        var bankDue = $('#bankDue').val();
        var commission = $('#commission').val();
        var insurance = $('#insurance').val();
        
        if(isNaN(dollarRate)){
            dollarRate=0;
        }
        if(isNaN(marginPercent)){
            marginPercent=0;
        }
        if(isNaN(commission)){
            commission=0;
        }
        if(isNaN(insurance)){
            insurance=0;
        }
        
        // total amount in bdt
        var _totalInBDT = parseFloat(subTotal)*parseFloat(dollarRate);
        $('#totalInBDT').val(_totalInBDT.toFixed(2));
        
        // margin amount
        var _marginAmount = (parseFloat(_totalInBDT)*parseFloat(marginPercent))/100;
        $('#marginAmount').val(_marginAmount.toFixed(2));
        
        // bank due
        var _bankDue=(_totalInBDT-_marginAmount)/parseFloat(dollarRate);
        $('#bankDue').val(_bankDue.toFixed(2));
    }
</script>
@endsection 