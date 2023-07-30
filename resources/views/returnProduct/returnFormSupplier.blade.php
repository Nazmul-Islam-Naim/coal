@extends('layouts.layout')
@section('title', 'Return Product')
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
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <!-- <h1> PURCHASE PRODUCT <small></small> </h1> -->
  

  <div class="form-inline">
    <div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.purchase').'/purchase-report'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Purchase Report</a>
    </div>
    <div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Accounts</a>
    </div>
    <div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Supplier</a>
    </div>
  </div>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Return Product</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    {!! Form::open(array('route' =>['supplier-return-from-submit.store'],'method'=>'POST')) !!}
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Return Product From Purchase</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group"> 
                <label>{{ __('messages.supplier') }} <span style="color: red">*</span></label>
                <select class="form-control select2" name="supplier_id" required=""> 
                  <option value="">Select</option>
                  @foreach($allsupplier as $supplier)
                  <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> 
                <label>{{ __('messages.date') }} <span style="color: red">*</span></label>
                <input type="text" name="return_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" required="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> 
                <label>{{ __('messages.note') }}</label>
                <textarea class="form-control" name="note" rows="1"></textarea>
              </div>
            </div>
            <!--<div class="col-md-3">
              <div class="form-group"> 
                <label>Payment Method <span style="color: red">*</span></label>
                <select class="form-control select2" name="payment_method" required=""> 
                  <option value="">Select</option>
                  @foreach(\App\Models\BankAccount::all() as $value)
                  <option value="{{$value->id}}">{{$value->bank_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>-->
            <div class="col-md-12">
              <div class="panel panel-primary">
                <div class="panel-heading">{{ __('messages.add_product_details') }}</div>
                <div class="panel-body"> 
                  <div class="table-responsive"> 
                  <table class="table"> 
                    <thead> 
                      <tr>
                        <th style="text-align: center">{{ __('messages.item_information') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.stock_qnty') }}</th>
                        <th style="text-align: center">{{ __('messages.quantity') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.unit_price') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.row_total') }}</th>
                        <th style="text-align: center">{{ __('messages.action') }}</th> 
                      </tr> 
                    </thead>
                    <?php $row_num = 1; ?>
                    <tbody class="row_container"> 
                      <tr id="div_{{$row_num}}"> 
                        <td width="20%">
                          <select name="purchase_details[{{$row_num}}][product_id]" class="form-control select2" required="" onchange="getProductDetails(this.value, <?php echo $row_num?>);"> 
                            <option value="">Select</option>
                            @foreach($allproduct as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td> 
                          <input type="text" class="form-control" id="stockqnty_{{$row_num}}" readonly>
                        </td>
                        <td> 
                          <input type="number" name="purchase_details[{{$row_num}}][return_qnty]" class="form-control" id="quantity_{{$row_num}}" onkeyup="multiply(<?php echo $row_num?>);" required="" autocomplete="off">
                        </td>
                        <td> 
                          <input type="number" step="any" name="purchase_details[{{$row_num}}][unit_price]" class="form-control" id="rate_{{$row_num}}" onkeyup="multiply(<?php echo $row_num?>);" required="" autocomplete="off">
                        </td>
                        <td> 
                          <input type="text" name="total[]" class="form-control" id="Total_{{$row_num}}" readonly>
                        </td>
                        <td></td> 
                      </tr> 
                    </tbody> 
                    <tfoot>
                      <tr> 
                          <td colspan="3" rowspan="3">
                            <center><label for="details" class="  col-form-label text-center">{{ __('messages.reason') }}</label></center>
                            <textarea class="form-control" name="details" id="details" placeholder="Reason"></textarea> <br>
                            <label>{{ __('messages.usability') }} </label><br>
                            <label><input type="radio" checked="checked" name="usability" value="1"> Adjust With Stock</label>
                          </td>
                      </tr>
                      <tr> 
                        <td style="text-align: right"><b>{{ __('messages.row_total') }}</b></td>
                        <td>
                          <input type="text" name="total_return_amount" class="form-control" id="subTotal" value="0" readonly>
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow()"><i class="fa fa-plus"></i></a>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="5" style="text-align: right">
                          <input type="submit" name="purchase" class="btn btn-sm btn-success" value="Return">
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
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
    {!! Form::close() !!}
  </div>
</section>
<!-- /.content -->

<?php
  $result = "";
  foreach ($allproduct as $value) {
    $result .= '<option value="'.$value["id"].'">'.$value["name"].'</option>';
  }
?>

<script type="text/javascript">
  // dynamic add more field
  var Result = '<?php echo $result;?>';
  var RowNum = '<?php echo $row_num;?>'; 
  function addrow(){ 
    RowNum++; 
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html +='<td>'; 
    html +='<select class="form-control" name="purchase_details['+RowNum+'][product_id]" onchange="getProductDetails(this.value, '+RowNum+')"><option value="">Select</option>'+Result+'</select>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" class="form-control" id="stockqnty_'+RowNum+'" readonly>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" name="purchase_details['+RowNum+'][return_qnty]" class="form-control" id="quantity_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" step="any" name="purchase_details['+RowNum+'][unit_price]" class="form-control" id="rate_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off">'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" name="total[]" class="form-control" id="Total_'+RowNum+'" readonly>'; 
    html +='</td>';
    html +='<td>'; 
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
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
      document.getElementById('grandTotal').value = tot.toFixed(2);
      document.getElementById('dueAmount').value = tot.toFixed(2);
  }

  function discountFun(value) {
    var SubTotal = document.getElementById('subTotal').value;
    var DiscountAmount = (parseFloat(SubTotal)*parseFloat(value))/100;

    var AmountAfterDiscount = parseFloat(SubTotal)-parseFloat(DiscountAmount);

    if (isNaN(AmountAfterDiscount)) {
      document.getElementById('grandTotal').value = 0;
      document.getElementById('dueAmount').value = 0;
    }else{
      document.getElementById('grandTotal').value = AmountAfterDiscount.toFixed(2);
      document.getElementById('dueAmount').value = AmountAfterDiscount.toFixed(2);
    }
  }

  function paidFun(value) {
    var GrandTotal = document.getElementById('grandTotal').value;
    var DueAfterPaid = parseFloat(GrandTotal)-parseFloat(value);

    if (isNaN(DueAfterPaid)) {
      document.getElementById('dueAmount').value = 0;
    }else{
      document.getElementById('dueAmount').value = DueAfterPaid.toFixed(2);
    }
  }
</script>
@endsection