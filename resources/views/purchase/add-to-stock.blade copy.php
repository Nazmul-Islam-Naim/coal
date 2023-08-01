@extends('layouts.layout')
@section('title', 'Add Product to Stock')
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
    <!--<div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.purchase').'/purchase-report'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Purchase Report</a>
    </div>
    <div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Accounts</a>
    </div>-->
    <div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.sm').'/stock-product'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> Main Stock</a>
    </div>
  </div>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.add_to_stock') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    {!! Form::open(array('route' =>['add-to-stock.store'],'method'=>'POST')) !!}
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.add_to_stock') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group"> 
                <label>{{ __('messages.date') }} <span style="color: red">*</span></label>
                <input type="text" name="stock_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" required="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group"> 
                <label>{{ __('messages.note') }}</label>
                <textarea class="form-control" name="note" rows="1"></textarea>
              </div>
            </div>
            {{-- <div class="col-md-4">
              <div class="form-group"> 
                <label>{{ __('messages.product_type') }} <span style="color: red">*</span></label>
                <select class="form-control select2" name="product_type_id" id="productTypeId" required=""> 
                  <option value="">--Select--</option>
                  @foreach(\App\Models\ProductType::all() as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div> --}}
            <div class="col-md-4">
              <div class="form-group"> 
                <label>{{ __('messages.product_type') }} <span style="color: red">*</span></label>
                <select class="form-control select2" name="product_type_id" id="productTypeId" required=""> 
                  <option value="">--Select--</option>
                  @foreach($lcInfos as $lcInfo)
                  <option value="{{$lcInfo->lc_no}}">{{$lcInfo->lc_no}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 15px">
                <span id="supplierInfo"></span>
            </div>
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
                       
                    </tbody> 
                    <tfoot>
                      <tr> 
                        <td colspan="4" style="text-align: right"><b>{{ __('messages.row_total') }}</b></td>
                        <td>
                          <input type="text" name="sub_total" class="form-control bookSubTtlPrice" id="subTotal" value="0" readonly>
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();getTypeWiseProductForRepeat(productTypeId.value)"><i class="fa fa-plus"></i></a>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="5" style="text-align: right">
                          <button type="submit" name="purchase" class="btn btn-md btn-success" onclick="return confirm('Are you sure?')"><i class="fa fa-plus-circle"></i> Add to Stock</button>
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
  foreach ($lcProducts as $value) {
    $result .= '<option value="'.$value["product"]->id.'">'.$value['product']->name.'</option>';
  }
?>

<script type="text/javascript">
  // type wise product
    $('#productTypeId').change(function(){
        var value=$('#productTypeId').val();
        
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: "{{$baseUrl.'/'.config('app.sm').'/find-product-details-with-type-id'}}",
          data: {
            'type_id' : value,
          },
          dataType: "json",
          success:function(data) {
                console.log(data);
                $("select.allProductList").empty();
                $(".individualBookStockQnty").val('');
                $(".individualBookQnty").val('');
                $(".individualBookPrice").val('');
                $(".individualBookTtlPrice").val('');
                $(".bookSubTtlPrice").val('');
              
                $("select.allProductList").append('<option  value="">--Select--</option>');
                $.each(data, function(key, value){
                    console.log(value.name);
                    $("select.allProductList").append('<option  value='+value.id+'>'+value.name+'</option>');
                });
          }
        });
    });
    
    var value = document.getElementById('productTypeId').value;
    function getTypeWiseProductForRepeat(value){
        //alert(value);
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          //url: "{{URL::to('find-product-details-with-id')}}",
          url: "{{$baseUrl.'/'.config('app.sm').'/find-product-details-with-type-id'}}",
          data: {
            'type_id' : value,
          },
          dataType: "json",
          success:function(data) {
              console.log(data);
            $("select.allProductList").empty();
            $(".individualBookStockQnty").val('');
            $(".individualBookQnty").val('');
            $(".individualBookPrice").val('');
            $(".individualBookTtlPrice").val('');
            $(".bookSubTtlPrice").val('');
            $("select.allProductList").append('<option  value="">--Select--</option>');
            $.each(data, function(key, value){
                console.log(value.name);
                $("select.allProductList").append('<option  value='+value.id+'>'+value.name+'</option>');
            });
          }
        });
    }

  // dynamic add more field
  var Result = '<?php echo $result;?>';
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
    html +='<select class="form-control allProductList select2" name="purchase_details['+RowNum+'][product_id]" onchange="getProductDetails(this.value, '+RowNum+')" required=""></select>'; 
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
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate()"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
    $(".select2").select2({});
    RowNum++;
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
  
  function calculate() {
    var arr = document.getElementsByName('total[]');
    var tot=0;
    for(var i=0;i<arr.length;i++){
      if(parseInt(arr[i].value))
        tot += parseInt(arr[i].value);
    }
    document.getElementById('subTotal').value = tot;
  }
  
    $('#supplierId').on("change",function(){
        if($(this).val() != ""){
            var dataid = $("#supplierId option:selected").attr('data-id');
            var dataname = $("#supplierId option:selected").attr('data-name');
            var dataphone = $("#supplierId option:selected").attr('data-phone');
            var datacompany = $("#supplierId option:selected").attr('data-company');
            
            var Html = 'Name : '+dataname+' || ID : '+dataid+' || Phone : '+dataphone+' || Company : '+datacompany;
            $('#supplierInfo').html(Html);
        }else{
            var Html = '';
            $('#supplierInfo').html(Html);
        }
    });
</script>
@endsection