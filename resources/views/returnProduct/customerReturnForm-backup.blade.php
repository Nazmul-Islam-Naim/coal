@extends('layouts.layout')
@section('title', 'Customer Return Form')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.sell_return_from_customer') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Return</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa fa-retweet"></i> {{ __('messages.sell_return_from_customer') }}</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['customer-return-from-submit.store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <th colspan="3">{{ __('messages.customer') }} {{ __('messages.name') }}</th>
                      <th colspan="3">{{$singledata->productsell_customer_object->name}}</th>
                      <input type="hidden" name="customer_id" value="{{$singledata->customer_id}}">
                      <input type="hidden" name="tok" value="{{$singledata->tok}}">
                      <input type="hidden" name="invoice_no" value="{{$singledata->invoice_no}}">
                    </tr>
                    <tr> 
                      <th colspan="3">{{ __('messages.invoice') }}</th>
                      <th colspan="3">{{$singledata->invoice_no}}</th>
                    </tr>
                  </thead>
                </table>

                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <th width="30%">{{ __('messages.item_information') }}</th>
                      <th width="15%">{{ __('messages.sold_qnty') }}</th>
                      <th width="10%">{{ __('messages.return_qnty') }} <span style="color: red">*</span></th>
                      <th width="20%">{{ __('messages.unit_price') }}</th>
                      <th width="20%">{{ __('messages.row_total') }}</th>
                      <th width="5%"><a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow()"><i class="fa fa-plus"></i></a> </th>
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
                      <td>
                        {{$data->productsell_product_object->name}}
                        <input type="hidden" name="multidata[<?php echo $rowCount?>][product_id]" value="{{$data->product_id}}">
                      </td>
                      <td>{{$data->quantity}}</td>
                      <td> 
                        <input type="number" name="multidata[<?php echo $rowCount?>][return_qnty]" class="form-control" id="RQnty_{{$rowCount}}" value="" onkeyup="multiply(<?php echo $rowCount?>);" autocomplete="off" min="1" required="">
                      </td>
                      <td> 
                        <input type="text" name="multidata[<?php echo $rowCount?>][rate]" class="form-control" id="Rate_{{$rowCount}}" value="{{$data->unit_price}}" readonly="" onkeyup="multiply(<?php echo $rowCount?>);">
                      </td>
                      <td> 
                        <input type="text" name="multidata[<?php echo $rowCount?>][total_amount]" class="form-control" id="Total_{{$rowCount}}" value="" readonly="">

                        <input type="hidden" name="total[]" id="Total_Hidden_{{$rowCount}}" value="">
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr> 
                      <td colspan="3" rowspan="3">
                        <textarea class="form-control" name="details" id="details" placeholder="Reason" rows="1"></textarea>
                      </td>
                      <td style="text-align:right">{{ __('messages.return_amount') }} :</td>
                      <td> 
                        <input type="text" name="total_return_amount" id="totalReturnAmount" class="form-control" value="" readonly="">
                      </td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                  <button type="submit" class="btn btn-success btn-lg">Return</button>
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
    html +='<select class="form-control" name="multidata['+RowNum+'][product_id]" onchange="getProductDetails(this.value, '+RowNum+')"><option value="">Select</option>'+Result+'</select>'; 
    html +='</td>'; 
    html +='<td>';
    html +='Stock Qnty<input type="text" class="form-control" id="stockqnty_'+RowNum+'" readonly>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" name="multidata['+RowNum+'][return_qnty]" class="form-control" id="RQnty_'+RowNum+'" onkeyup="multiply('+RowNum+');" min="1" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" name="multidata['+RowNum+'][rate]" class="form-control" id="Rate_'+RowNum+'" onkeyup="multiply('+RowNum+');" readonly="">'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" name="multidata['+RowNum+'][total_amount]" class="form-control" id="Total_'+RowNum+'" value="" readonly=""><input type="hidden" name="total[]" id="Total_Hidden_'+RowNum+'" value="">';
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
        $('#Rate_'+RowNums).val(data.price);
        //$('#vatpercent_'+RowNums).val(data.vat_percent);
        $('#stockqnty_'+RowNums).val(data.quantity);
      }
    });
  }

  function multiply(RowNum) {
    //alert(RowNum);
    var ReturnQnty = document.getElementById('RQnty_'+RowNum).value;
    var Rate = document.getElementById('Rate_'+RowNum).value;

    var Total = parseFloat(ReturnQnty)*parseFloat(Rate);
    if (isNaN(Total)) {
      document.getElementById('Total_'+RowNum).value = 0;
      document.getElementById('Total_Hidden_'+RowNum).value = 0;
    }else{
      document.getElementById('Total_'+RowNum).value = Total.toFixed(2);
      document.getElementById('Total_Hidden_'+RowNum).value = Total.toFixed(2);
    }
    
    var array = document.getElementsByName('total[]');
    var total=0;
    for(var i=0;i<array.length;i++){
      if(parseFloat(array[i].value))
        total += parseFloat(array[i].value);
    }
    document.getElementById('totalReturnAmount').value = total.toFixed(2);
  }
</script>
@endsection 