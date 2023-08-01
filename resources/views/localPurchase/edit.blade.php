@extends('layouts.layout')
@section('title', 'Local Purchase')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>Local Purchase<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">Local Purchase</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        {!! Form::open(array('route' =>['local-purchases.update',$localPurchase->id],'method'=>'PUT')) !!}
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Update Local Purchase</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
                <a href="{{route('local-purchases.index')}}" class="btn btn-warning btn-sm"><i class="fa fa-list"></i> Report </a>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4 form-group"> 
                <label>Supplier Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$localPurchase->supplier->name ?? ''}}" autocomplete="off" readonly>
                <input type="hidden" name="local_supplier_id" class="form-control" value="{{$localPurchase->local_supplier_id}}" autocomplete="off">
              </div>
              <div class="col-md-4 form-group"> 
                <label>Purchase Date<span class="text-danger">*</span></label>
                <input type="date" name="date" class="form-control" value="{{$localPurchase->date}}" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Note</label> 
                <input type="text" name="note" class="form-control" value="{{$localPurchase->note}}" autocomplete="off" >
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
                        <th style="text-align: center">{{ __('messages.unit_price') }}<span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.row_total') }}</th>
                        <th style="text-align: center">{{ __('messages.action') }}</th> 
                      </tr> 
                    </thead>
                    <?php $row_num = 1; ?>
                    <tbody class="row_container"> 
                        @if(!empty($localPurchase))
                            @foreach($localPurchase->purchaseDetails as $value)
                            <tr id="div_{{$row_num}}">
                                <td> 
                                    <select class="form-control allProductTypeList select2" onchange="productTypeId({{$row_num}})" id="productTypeId_{{$row_num}}" name="purchase_details[{{$row_num}}][product_type_id]" required="">
                                        <option value="">--Select--</option>
                                        @foreach($allproducttype as $type)
                                        <option value="{{$type->id}}" {{($type->id==$value->product->product_type_id)?'selected':''}}>{{$type->name}}</option>
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
                                    <input type="text" class="form-control individualBookStockQnty" id="stockqnty_{{$row_num}}" value="{{$value->product->stock->quantity ?? ''}}" readonly>
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
                                    <a href="javascript:;" class="btn btn-sm btn-danger pull-right" onclick="$('#div_{{$row_num}}').remove();subTotal()"><i class="fa fa-remove"></i></a>
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
                          <input type="text" name="sub_total" class="form-control bookSubTtlPrice" id="subTotal" value="{{$localPurchase->amount}}" readonly>
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();"><i class="fa fa-plus"></i></a>
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
            <input type="submit" class="btn btn-success btn-sm" value="Update Local Purchase" onclick="return confirm('Are you sure?')" style="width: 15%; float: right; font-weight: bold">
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
    html +='<a href="javascript:;" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();subTotal()"><i class="fa fa-remove"></i></a>'; 
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
          url: "{{$baseUrl.'/'.config('app.sell').'/find-product-details-with-id'}}",
          data: {
            'id' : value
          },
          dataType: "json",
          success:function(data) {
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
        subTotal();
    }

    function subTotal() {
        var arr = document.getElementsByName('total[]');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
        document.getElementById('subTotal').value = tot.toFixed(2);
    }
</script>
@endsection 