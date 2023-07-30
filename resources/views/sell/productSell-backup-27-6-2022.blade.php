@extends('layouts.layout')
@section('title', 'Sell Product')
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
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Sell</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    {!! Form::open(array('route' =>['product-sell.store'],'method'=>'POST')) !!}
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> SELL PRODUCT</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group"> 
                <label>Customer <span style="color: red">*</span></label>
                <select class="form-control select2" name="customer_id" id="supplierId" required=""> 
                  <option value="">--Select--</option>
                  @foreach($allcustomer as $customer)
                  <option value="{{$customer->id}}" data-name="{{$customer->name}}" data-id="{{$customer->customer_id}}" data-phone="{{$customer->phone}}" data-company="{{$customer->company}}">{{$customer->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group"> 
                <label>Truck/Ship Number <span style="color: red">*</span></label>
                <input type="text" name="truck_no" class="form-control" value="" required="">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group"> 
                <label>{{ __('messages.date') }} <span style="color: red">*</span></label>
                <input type="text" name="sell_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" required="">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group"> 
                <label>{{ __('messages.note') }}</label>
                <textarea class="form-control" name="note" rows="1"></textarea>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group"> 
                <label>Branch Name <span style="color: red">*</span></label>
                <select class="form-control select2" name="branch_id" id="BranchId" required=""> 
                  <option value="">--Select--</option>
                  @foreach(\App\Models\Branch::all() as $branch)
                  <option value="{{$branch->id}}">{{$branch->name}}</option>
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
                        <th style="text-align: center">{{ __('messages.product') }} <span style="color: red">*</span></th>
                        <!--<th style="text-align: center">Type</th>-->
                        <th style="text-align: center">{{ __('messages.quantity') }} (TON) <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.unit_price') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.row_total') }}</th>
                        <!--<th style="text-align: center">Conversion</th>
                        <th style="text-align: center">Quantity (MT)</th>-->
                        <th style="text-align: center">{{ __('messages.action') }}</th> 
                      </tr> 
                    </thead>
                    <?php $row_num = 1; ?>
                    <tbody class="row_container"> 
                       
                    </tbody> 
                    <tfoot>
                      <tr> 
                        <td colspan="3" style="text-align: right"><b>{{ __('messages.row_total') }}</b></td>
                        <td>
                          <input type="text" name="sub_total" class="form-control bookSubTtlPrice" id="subTotal" value="0" readonly>
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();getTypeWiseProductForRepeat(BranchId.value)"><i class="fa fa-plus"></i></a>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="3" style="text-align: right"><b>Paid Amount</b></td>
                        <td>
                          <input type="text" name="paid_amount" class="form-control" id="paidAmount" value="0">
                        </td>
                        <td></td>
                      </tr>
                      <tr> 
                        <td colspan="3" style="text-align: right"><b>Receive Method</b></td>
                        <td>
                          <select name="bank_id" class="form-control select2">
                              <option value="">--Select--</option>
                              @foreach(\App\Models\BankAccount::all() as $value)
                              <option value="{{$value->id}}">{{$value->bank_name}}</option>
                              @endforeach
                          </select>
                        </td>
                        <td></td>
                      </tr>
                      <tr> 
                        <td colspan="4" style="text-align: right">
                          <button type="submit" name="purchase" class="btn btn-md btn-success"><i class="fa fa-shopping-cart"></i> Sell</button>
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
  // type wise product
    $('#BranchId').change(function(){
        var value=$('#BranchId').val();
        
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: "{{$baseUrl.'/'.config('app.sell').'/find-product-details-with-branch-id'}}",
          data: {
            'branch_id' : value,
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

    function getTypeWiseProductForRepeat(value){
        //alert(value);
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          //url: "{{URL::to('find-product-details-with-id')}}",
          url: "{{$baseUrl.'/'.config('app.sell').'/find-product-details-with-branch-id'}}",
          data: {
            'branch_id' : value,
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
                    $("select.allProductList").append('<option  value='+value.id+' data-quantity="'+value.quantity+'">'+value.name+'('+value.quantity+')'+'</option>');
                });
          }
        });
    }

  // dynamic add more field
  var Result = '<?php echo $result;?>';
  var RowNum = '<?php echo $row_num;?>'; 
  function addrow(){  
    if($('#BranchId').val() == ""){
        alert('At first Select Branch !');
        //$('#BranchId').open();
        return true;
    }
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html +='<td>'; 
    html +='<select class="form-control allProductList select2" name="sell_details['+RowNum+'][product_id]" onchange="getProductDetails(this.value, '+RowNum+')"></select>'; 
    html +='</td>'; 
    /* html +='<td>'; 
    html +='<select class="form-control" name="sell_details['+RowNum+'][type]"><option value="">--Select--</option><option value="CFT">CFT</option><option value="TON">TON</option></select>'; 
    html +='</td>';*/
    html +='<td>';
    html +='<input type="number" name="sell_details['+RowNum+'][quantity]" class="form-control individualBookQnty" id="quantity_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" step="any" name="sell_details['+RowNum+'][unit_price]" class="form-control individualBookPrice" id="rate_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off">'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" name="total[]" class="form-control individualBookTtlPrice" id="Total_'+RowNum+'">'; 
    html +='</td>';
    /*html +='<td>';
    html +='<input type="text" name="sell_details['+RowNum+'][conversion]" class="form-control" value="1" id="Conversion_'+RowNum+'" onkeyup="conversion('+RowNum+');">'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text"  class="form-control" id="TotalQnty_'+RowNum+'">'; 
    html +='</td>';*/
    html +='<td>'; 
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate()"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
    RowNum++;
    $(".select2").select2({});
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
    
    // call conversion function
    //conversion(RowNum);
      
      
    // summation of total in total field
    var arr = document.getElementsByName('total[]');
    RowNum++;
    var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseFloat(arr[i].value))
              tot += parseFloat(arr[i].value);
      }
      
      
      
      document.getElementById('subTotal').value = tot.toFixed(2);
      /*document.getElementById('grandTotal').value = tot.toFixed(2);
      document.getElementById('dueAmount').value = tot.toFixed(2);*/
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
  
  /*function conversion(RowNum){
      //alert(RowNum);
      var TotalAmount = $('#Total_'+RowNum).val();
      var ConversionValue = $('#Conversion_'+RowNum).val();
      //alert(ConversionValue);
      
      if(isNaN(ConversionValue)){
          var TotalQnty = parseFloat(TotalAmount)/parseFloat(ConversionValue);
          $('#TotalQnty_'+RowNum).val(0);
      }else{
        var TotalQnty = parseFloat(TotalAmount)/parseFloat(ConversionValue);
        $('#TotalQnty_'+RowNum).val(TotalQnty.toFixed(2));
      }
      
      // summation of total in total field
      var arr = document.getElementsByName('total[]');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseFloat(arr[i].value))
              tot += parseFloat(arr[i].value);
      }
      document.getElementById('subTotal').value = tot.toFixed(2);
  }*/
  
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