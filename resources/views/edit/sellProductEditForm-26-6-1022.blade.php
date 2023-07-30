@extends('layouts.layout')
@section('title', 'Sell Product Edit Form')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<style type="text/css">
  .select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}
</style>
<section class="content-header">
  <h1> {{ __('messages.sell_product_edit') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa fa-pencil"></i> {{ __('messages.sell_product_edit') }}</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['sell-product-edit.update', $singledata->tok],'method'=>'PUT')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <th colspan="3">{{ __('messages.customer') }}</th>
                      <th colspan="3">
                          <select class="form-control" name="customer_id" style="width: 20%;">
                              @foreach(\App\Models\Customer::all() as $customer)
                              <option value="{{$customer->id}}" {{($customer->id==$singledata->customer_id)?'selected':''}}>{{$customer->name}}</option>
                              @endforeach
                          </select>
                      </th>
                    </tr>
                    <tr> 
                      <th colspan="3">{{ __('messages.invoice') }}</th>
                      <th colspan="3">{{$singledata->invoice_no}} <input type="hidden" name="invoice_no" value="{{$singledata->invoice_no}}"> <input type="hidden" name="payment_method" value="{{$singledata->payment_method}}"></th>
                    </tr>
                    <tr> 
                      <th colspan="3">Sell Date</th>
                      <th colspan="3"><input type="text" name="sell_date" class="form-control datepicker" value="{{$singledata->sell_date}}" style="width: 20%;"></th>
                    </tr>
                  </thead>
                </table>

                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                        <th style="text-align: center; width: 20%">{{ __('messages.item_information') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.stock_qnty') }}</th>
                        <th style="text-align: center">{{ __('messages.quantity') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.unit_price') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.vat') }}</th>
                        <th style="text-align: center">{{ __('messages.row_total') }}</th>
                        <th style="text-align: center">{{ __('messages.action') }}</th> 
                    </tr>
                  </thead>
                  <tbody class="row_container"> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                    ?>
                    @foreach($alldata as $data)
                    <?php $rowCount++;?>
                    <tr id="div_{{$rowCount}}"> 
                        <td style="width: 20%">
                          {{$data->productsell_product_object->name}}

                          <?php
                            $sqlData = DB::table('product')->where('id', $data->product_id)->first();
                          ?>
                          <input type="hidden" name="sell_details[<?php echo $rowCount?>][id]" value="{{$data->id}}">
                          <input type="hidden" name="sell_details[<?php echo $rowCount?>][product_id]" value="{{$data->product_id}}">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="stockqnty_{{$rowCount}}" value="{{$data->stockQnty}}" readonly> 
                        </td>
                        <td> 
                          <input type="text" name="sell_details[{{$rowCount}}][quantity]" class="form-control" id="quantity_{{$rowCount}}" onkeyup="multiply(<?php echo $rowCount?>);" required="" value="{{$data->quantity}}">
                        </td>
                        <td> 
                          <input type="text" name="sell_details[{{$rowCount}}][unit_price]" class="form-control" id="rate_{{$rowCount}}" onkeyup="multiply(<?php echo $rowCount?>);" required="" value="{{$data->unit_price}}">

                          <input type="hidden" value="{{$sqlData->vat_percent}}" id="vatpercent_<?php echo $rowCount?>">
                          <input type="hidden" name="sell_details[{{$rowCount}}][purchase_value]" value="{{$data->stockUnitPrice}}" id="purchaserate_<?php echo $rowCount?>">
                        </td>
                        <td> 
                          <input type="text" name="vat[]" id="vatamount_<?php echo $rowCount?>" class="form-control" value="{{$data->vat_amount}}"><input type="hidden" name="sell_details[<?php echo $rowCount?>][vat_amount]" id="totalvatamount_<?php echo $rowCount?>" value="{{$data->vat_amount}}">
                        </td>
                        <td> 
                          <input type="text" name="total[]" class="form-control" id="Total_{{$rowCount}}" value="{{$data->quantity*$data->unit_price}}">
                        </td>
                        <td>
                            <a href="{{URL::to('sells/sell-product-delete', [$data->product_id, $data->tok])}}" class="btn btn-danger btn-xs" onclick="return confirm('Want to Delete This Sell?');"><i class="fa fa-remove"></i></a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>Sub Total</b></td>
                        <td>
                          <input type="text" name="sub_total" class="form-control" id="subTotal" value="{{!empty($singledata->sub_total)? $singledata->sub_total:0}}" readonly="">
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-primary pull-right" onclick="addrow()"><i class="fa fa-plus"></i></a>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>{{ __('messages.discount_type') }}</b></td>
                        <td>
                          <input class="form-control" name="discount_type" id="DiscountType" value="{{$singledata->discount_type}}" readonly>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>Discount Amount</b></td>
                        <td>
                          <input type="text" class="form-control" name="given_discount" id="Discount" value="{{$singledata->given_discount}}" onkeyup="discountFun(this.value);" autocomplete="off">
                          <input type="hidden" name="discount" id="DiscountAmount" value="{{$singledata->discount}}">
                        </td>
                      </tr>
                      <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.vat') }}</b></td>
                      <td>
                        <input type="text" name="total_vat" class="form-control" id="totalVat" value="{{$singledata->total_vat}}" readonly="">
                      </td>
                    </tr>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>Grand Total</b></td>
                        <td>
                          <input type="text" name="grand_total" class="form-control" id="grandTotal" value="{{$singledata->grand_total}}" readonly="">
                          <input type="hidden" id="grandTotalHidden" value="{{$singledata->grand_total}}">
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>{{ __('messages.paid_amount') }}</b></td>
                        <td>
                          <input type="text" name="paid_amount" class="form-control" id="paidAmount" value="{{!empty($singledata->paid_amount)? $singledata->paid_amount:0}}" onkeyup="paidFun(this.value);" autocomplete="off">
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>{{ __('messages.due_amount') }}</b></td>
                        <td>
                          <input type="text" class="form-control" id="dueAmount" value="{{round($singledata->grand_total-$singledata->paid_amount, 2)}}" readonly="">
                        </td>
                      </tr>
                    </tfoot>
                </table>
                <div class="col-md-12" align="right">
                  <button type="submit" class="btn btn-success btn-sm">Update</button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        {!! Form::close() !!}
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<?php
  $result = "";
  foreach ($allproduct as $value) {
    $result .= '<option value="'.$value->id.'">'.$value->name.'</option>';
  }
?>

<script type="text/javascript">
  // dynamic add more field
  var Result = '<?php echo $result;?>';
  var RowNum = '<?php echo $rowCount;?>'; 
  function addrow(){ 
    RowNum++; 
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html +='<td>'; 
    html +='<select class="form-control select2" onchange="getProductDetails(this.value, '+RowNum+')" name="sell_details['+RowNum+'][product_id]"><option value="">Select</option>'+Result+'</select>'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" class="form-control" id="stockqnty_'+RowNum+'" readonly>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" name="sell_details['+RowNum+'][quantity]" class="form-control" id="quantity_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" name="sell_details['+RowNum+'][unit_price]" class="form-control" id="rate_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off"><input type="hidden" value="" id="vatpercent_'+RowNum+'"><input type="hidden" name="sell_details['+RowNum+'][purchase_value]" value="" id="purchaserate_'+RowNum+'">'; 
    html +='</td>';
    html += '<td><input type="text" name="vat[]" id="vatamount_'+RowNum+'" class="form-control" value="" readonly=""><input type="hidden" name="sell_details['+RowNum+'][vat_amount]" id="totalvatamount_'+RowNum+'"></td>';
    html +='<td>';
    html +='<input type="text" name="total[]" class="form-control" id="Total_'+RowNum+'" readonly="">'; 
    html +='</td>';
    html +='<td>'; 
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate();"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
    $('.select2').select2();
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
        $('#rate_'+RowNums).val(data.price);
        $('#vatpercent_'+RowNums).val(data.vat_percent);
        $('#stockqnty_'+RowNums).val(data.quantity);
        $('#purchaserate_'+RowNums).val(data.unit_price);
      }
    });
  }
  
  function calculate() {
    var arr = document.getElementsByName('total[]');
        var tot=0;
        for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
        }
        document.getElementById('subTotal').value = tot;
        var FinalGrandTotal = tot;
        //document.getElementById('paidAmount').value = (FinalGrandTotal).toFixed(2);
        document.getElementById('grandTotal').value = FinalGrandTotal.toFixed(2);
      document.getElementById('grandTotalHidden').value = FinalGrandTotal.toFixed(2);
      document.getElementById('dueAmount').value = FinalGrandTotal.toFixed(2);
      
      // checking discount
        var value = document.getElementById('Discount').value;
        if(value !=''){
            var DiscountType = document.getElementById('DiscountType').value;
            var GrandTotalHidden = document.getElementById('subTotal').value;
            if (DiscountType=='percent') {
              var DiscountAmount = (parseFloat(GrandTotalHidden)*parseFloat(value))/100;
              var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
              if (isNaN(AmountAfterDiscount)) {
                document.getElementById('grandTotal').value = 0;
                document.getElementById('dueAmount').value = 0;
                document.getElementById('DiscountAmount').value = 0;
              }else{
                var TotalVat = document.getElementById('totalVat').value;
                var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
                document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
                document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
                document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
              }
            }else if(DiscountType=='amount'){
              var DiscountAmount = parseFloat(value);
              var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
              if (isNaN(AmountAfterDiscount)) {
                document.getElementById('grandTotal').value = 0;
                document.getElementById('dueAmount').value = 0;
                document.getElementById('DiscountAmount').value = 0;
              }else{
                var TotalVat = document.getElementById('totalVat').value;
                var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
                document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
                document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
                document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
              }
            }
        }
  }

  function multiply(RowNum){
    var StockQnty = document.getElementById('stockqnty_'+RowNum).value;
    var qnty = document.getElementById('quantity_'+RowNum).value;
    var rate = document.getElementById('rate_'+RowNum).value;
    if(parseInt(qnty)>parseInt(StockQnty)){
        alert('Input Quantity Must be Samller or Equal of Stock Quantity');
        document.getElementById('quantity_'+RowNum).value = '0';
        
        document.getElementById('Total_'+RowNum).value = 0;
        document.getElementById('subTotal').value = 0;
        document.getElementById('grandTotal').value = 0;
        document.getElementById('grandTotalHidden').value = 0;
    }else{
    var total = parseFloat(qnty)*parseFloat(rate);

    var vatPercent = document.getElementById('vatpercent_'+RowNum).value;
    var vatAmount = parseFloat(total)*parseFloat(vatPercent)/100;

    if (isNaN(total)) {
      document.getElementById('Total_'+RowNum).value = 0;
      document.getElementById('vatamount_'+RowNum).value = 0;
      document.getElementById('totalvatamount_'+RowNum).value = 0;
    }else{
      document.getElementById('Total_'+RowNum).value = total.toFixed(2);
      document.getElementById('vatamount_'+RowNum).value = vatAmount.toFixed(2);
      document.getElementById('totalvatamount_'+RowNum).value = vatAmount.toFixed(2);
    }

    // summation of total in total field

    var arr = document.getElementsByName('total[]');
    RowNum++;
    var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseFloat(arr[i].value))
              tot += parseFloat(arr[i].value);
      }
      document.getElementById('subTotal').value = tot;
      //document.getElementById('grandTotal').value = tot;
      //document.getElementById('dueAmount').value = tot;

      var vatArr = document.getElementsByName('vat[]');
      var totVat=0;
      for(var i=0;i<vatArr.length;i++){
        if(parseFloat(vatArr[i].value))
          totVat += parseFloat(vatArr[i].value);
      }
      document.getElementById('totalVat').value = totVat;

      var FinalGrandTotal = tot+totVat;
      document.getElementById('grandTotal').value = FinalGrandTotal.toFixed(2);
      document.getElementById('grandTotalHidden').value = FinalGrandTotal.toFixed(2);
      document.getElementById('dueAmount').value = FinalGrandTotal.toFixed(2);
      
      //document.getElementById('dueAmount').value = 0;
    }
    
    // checking discount
        var value = document.getElementById('Discount').value;
        if(value !=''){
            var DiscountType = document.getElementById('DiscountType').value;
            var GrandTotalHidden = document.getElementById('subTotal').value;
            if (DiscountType=='percent') {
              var DiscountAmount = (parseFloat(GrandTotalHidden)*parseFloat(value))/100;
              var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
              if (isNaN(AmountAfterDiscount)) {
                document.getElementById('grandTotal').value = 0;
                document.getElementById('dueAmount').value = 0;
                document.getElementById('DiscountAmount').value = 0;
              }else{
                var TotalVat = document.getElementById('totalVat').value;
                var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
                document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
                
                var PaidAmnt = document.getElementById('paidAmount').value;
                document.getElementById('dueAmount').value = parseFloat(FinalAmountAfterDiscount) - parseFloat(PaidAmnt);
                //document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
                document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
              }
            }else if(DiscountType=='amount'){
              var DiscountAmount = parseFloat(value);
              var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
              if (isNaN(AmountAfterDiscount)) {
                document.getElementById('grandTotal').value = 0;
                document.getElementById('dueAmount').value = 0;
                document.getElementById('DiscountAmount').value = 0;
              }else{
                var TotalVat = document.getElementById('totalVat').value;
                var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
                document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
                var PaidAmnt = document.getElementById('paidAmount').value;
                document.getElementById('dueAmount').value = parseFloat(FinalAmountAfterDiscount) - parseFloat(PaidAmnt);
                //document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
                document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
              }
            }
        }
  }
  
  function changeDisType(DiscountType){
    var value = document.getElementById('Discount').value;
    var GrandTotalHidden = document.getElementById('subTotal').value;
    if (DiscountType=='percent') {
      var DiscountAmount = (parseFloat(GrandTotalHidden)*parseFloat(value))/100;
      var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
      if (isNaN(AmountAfterDiscount)) {
        document.getElementById('grandTotal').value = 0;
        document.getElementById('dueAmount').value = 0;
        document.getElementById('DiscountAmount').value = 0;
      }else{
        var TotalVat = document.getElementById('totalVat').value;
        var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
        document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
      }
    }else if(DiscountType=='amount'){
      var DiscountAmount = parseFloat(value);
      var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
      if (isNaN(AmountAfterDiscount)) {
        document.getElementById('grandTotal').value = 0;
        document.getElementById('dueAmount').value = 0;
        document.getElementById('DiscountAmount').value = 0;
      }else{
        var TotalVat = document.getElementById('totalVat').value;
        var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
        document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
      }
    }  
  }

  function discountFun(value) {
    var DiscountType = document.getElementById('DiscountType').value;
    var GrandTotalHidden = document.getElementById('subTotal').value;
    if (DiscountType=='percent') {
      var DiscountAmount = (parseFloat(GrandTotalHidden)*parseFloat(value))/100;
      var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
      if (isNaN(AmountAfterDiscount)) {
        document.getElementById('grandTotal').value = 0;
        document.getElementById('dueAmount').value = 0;
        document.getElementById('DiscountAmount').value = 0;
      }else{
        var TotalVat = document.getElementById('totalVat').value;
        var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
        document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
      }
    }else if(DiscountType=='amount'){
      var DiscountAmount = parseFloat(value);
      var AmountAfterDiscount = parseFloat(GrandTotalHidden)-parseFloat(DiscountAmount);
      if (isNaN(AmountAfterDiscount)) {
        document.getElementById('grandTotal').value = 0;
        document.getElementById('dueAmount').value = 0;
        document.getElementById('DiscountAmount').value = 0;
      }else{
        var TotalVat = document.getElementById('totalVat').value;
        var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
        document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
      }
    }
  }

  function paidFun(value) {
    var GrandTotal = document.getElementById('grandTotal').value;
    var DueAfterPaid = parseFloat(GrandTotal)-parseFloat(value);
    
    if (isNaN(DueAfterPaid)) {
      document.getElementById('dueAmount').value = 0;
    }else{
      document.getElementById('dueAmount').value = DueAfterPaid.toFixed(2);;
    }
  }
</script>
@endsection 