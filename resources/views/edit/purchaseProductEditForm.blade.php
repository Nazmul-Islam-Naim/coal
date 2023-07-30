@extends('layouts.layout')
@section('title', 'Purchase Product Edit Form')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.purchase_product_edit') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit</li>
  </ol>
</section>
<?php
  $baseUrl = URL::to('/');
?>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa fa-pencil"></i> {{ __('messages.purchase_product_edit') }}</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['purchase-product-edit.update', $singledata->tok],'method'=>'PUT')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <td>Supplier ID</td>
                      <td>{{$singledata->productpurchase_supplier_object->supplier_id}}</td>
                      <td>{{ __('messages.supplier') }}</td>
                      <td>{{$singledata->productpurchase_supplier_object->name}}</td>
                    </tr>
                    <tr> 
                      <td>Company</td>
                      <td>{{$singledata->productpurchase_supplier_object->company}}</td>
                      <td>Phone</td>
                      <td>{{$singledata->productpurchase_supplier_object->phone}}</td>
                    </tr>
                    <tr> 
                      <td>Address</td>
                      <td colspan="3">{{$singledata->productpurchase_supplier_object->address}}</td>
                    </tr>
                  </thead>
                </table>

                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <th width="45%">{{ __('messages.item_information') }}</th>
                      <th width="10%">{{ __('messages.quantity') }}</th>
                      <th width="20%">{{ __('messages.unit_price') }}</th>
                      <th width="20%">{{ __('messages.row_total') }}</th>
                      <th style="5%">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();"><i class="fa fa-plus"></i></a>
                      </th> 
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
                    <tr id="div_<?php echo $rowCount?>">
                      <td>
                        {{$data->productpurchase_product_object->name}}
                        <input type="hidden" name="multidata[<?php echo $rowCount?>][product_id]" value="{{$data->product_id}}">
                        <input type="hidden" name="multidata[<?php echo $rowCount?>][id]" value="{{$data->id}}">
                      </td>
                      <td>
                        <input type="text" name="multidata[<?php echo $rowCount?>][quantity]" class="form-control" id="Quantity_{{$rowCount}}" value="{{$data->quantity}}" onkeyup="multiply(<?php echo $rowCount?>);">
                      </td>
                      <td> 
                        <input type="text" name="multidata[<?php echo $rowCount?>][unit_price]" class="form-control" id="UnitPrice_{{$rowCount}}" value="{{$data->unit_price}}" onkeyup="multiply(<?php echo $rowCount?>);">
                      </td>
                      <td> 
                        <input type="text" name="multidata[<?php echo $rowCount?>][total_amount]" class="form-control" id="Total_{{$rowCount}}" value="{{$data->quantity*$data->unit_price}}" readonly="">

                        <input type="hidden" name="total[]" id="Total_Hidden_{{$rowCount}}" value="{{$data->quantity*$data->unit_price}}">
                      </td>
                      <td>
                          <!--<a href="javascript:0" class="btn btn-sm btn-danger pull-right"><i class="fa fa-remove"></i></a>-->
                          <a href="{{ URL::To('amendment/delete-purchase-product',[$data->id,$singledata->tok]) }}" onclick="return confirm('Are you sure to Delete this Item?')" class="btn btn-sm btn-danger pull-right"><i class="fa fa-remove"></i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr> 
                      <td colspan="3" style="text-align: right"><b>{{ __('messages.row_total') }}</b></td>
                      <td>
                        <input type="text" name="sub_total" class="form-control" id="subTotal" value="{{!empty($singledata->sub_total)? $singledata->sub_total:0}}" readonly="">
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
    $result .= '<option value="'.$value["id"].'">'.$value["name"].'</option>';
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
    html +='<select class="form-control allProductList select2" name="multidata['+RowNum+'][product_id]" onchange="getProductDetails(this.value, '+RowNum+')">'+Result+'</select>'; 
    html +='<input type="hidden" name="multidata['+RowNum+'][id]">'; 
    html +='</td>'; 
    /*html +='<td>';
    html +='<input type="text" class="form-control individualBookStockQnty" id="stockqnty_'+RowNum+'" readonly>'; 
    html +='</td>';*/ 
    html +='<td>';
    html +='<input type="number" name="multidata['+RowNum+'][quantity]" class="form-control individualBookQnty" id="Quantity_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" step="any" name="multidata['+RowNum+'][unit_price]" class="form-control individualBookPrice" id="UnitPrice_'+RowNum+'" onkeyup="multiply('+RowNum+');" autocomplete="off">'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" name="multidata['+RowNum+'][total_amount]" class="form-control" id="Total_'+RowNum+'" value="" readonly="">';

    html +='<input type="hidden" name="total[]" id="Total_Hidden_'+RowNum+'" value="">';
    
    html +='</td>';
    html +='<td>'; 
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate()"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
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

  function multiply(RowNum) {
    //alert(RowNum);
    var Quantity = document.getElementById('Quantity_'+RowNum).value;
    var UnitPrice = document.getElementById('UnitPrice_'+RowNum).value;

    var Total = parseFloat(Quantity)*parseFloat(UnitPrice);
    if (isNaN(Total)) {
      document.getElementById('Total_'+RowNum).value = 0;
      document.getElementById('Total_Hidden_'+RowNum).value = 0;
    }else{
      document.getElementById('Total_'+RowNum).value = Total.toFixed(2);
      document.getElementById('Total_Hidden_'+RowNum).value = Total.toFixed(2);
    }

    var arr = document.getElementsByName('total[]');
    RowNum++;
    var tot=0;
    for(var i=0;i<arr.length;i++){
      if(parseInt(arr[i].value))
      tot += parseInt(arr[i].value);
    }
    var SubTotals = document.getElementById('subTotal').value = tot;
    //var GrandTotals = document.getElementById('grandTotal').value = tot;
    //document.getElementById('dueAmount').value = tot;

    /*var GetDiscountValue = document.getElementById('Discount').value;
    var GetDiscountRes = (parseFloat(SubTotals)*parseFloat(GetDiscountValue))/100;

    var GrandTotals = document.getElementById('grandTotal').value = parseFloat(SubTotals)-parseFloat(GetDiscountRes);

    var PaidAmount = document.getElementById('paidAmount').value;
    var GetDueAmnt = parseFloat(GrandTotals)-parseFloat(PaidAmount);
    document.getElementById('dueAmount').value = GetDueAmnt;*/
  }

  function discountFun(value) {
    var SubTotal = document.getElementById('subTotal').value;
    var GetDiscountRes = parseFloat(SubTotal)*parseFloat(value)/100;
    var GetGrandTotalRes = parseFloat(SubTotal)-parseFloat(GetDiscountRes);
    if (isNaN(GetGrandTotalRes)) {
      document.getElementById('grandTotal').value = 0;
    }else{
      document.getElementById('grandTotal').value = GetGrandTotalRes;
    }
  }

  function paidFun(value) {
    var GrandTotal = document.getElementById('grandTotal').value;
    var DueAfterPaid = parseFloat(GrandTotal)-parseFloat(value);

    if (isNaN(DueAfterPaid)) {
      document.getElementById('dueAmount').value = 0;
    }else{
      document.getElementById('dueAmount').value = DueAfterPaid;
    }
  }
</script>
@endsection 