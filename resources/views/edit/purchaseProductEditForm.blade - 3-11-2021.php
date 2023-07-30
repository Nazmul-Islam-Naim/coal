@extends('layouts.layout')
@section('title', 'Purchase Product Edit Form')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> PURCHASE PRODUCT EDIT FORM <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa fa-retweet"></i> Purchase Product Edit Form</h3>
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
                      <th colspan="3">Supplier Name</th>
                      <th colspan="3">{{$singledata->productpurchase_supplier_object->name}}</th>
                    </tr>
                    <tr> 
                      <th colspan="3">Invoice</th>
                      <th colspan="3">{{$singledata->tok}}</th>
                    </tr>
                  </thead>
                </table>

                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <th width="20%">Item Information</th>
                      <th width="10%">Quantity</th>
                      <th width="20%">Unit Price</th>
                      <th width="20%">Total</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                    ?>
                    @foreach($alldata as $data)
                    <?php $rowCount++;?>
                    <tr>
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
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr> 
                      <td colspan="3" style="text-align: right"><b>Sub Total</b></td>
                      <td>
                        <input type="text" name="sub_total" class="form-control" id="subTotal" value="{{!empty($singledata->sub_total)? $singledata->sub_total:0}}">
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3" style="text-align: right"><b>Discount (%)</b></td>
                      <td>
                        <input type="text" name="discount" class="form-control" id="Discount" value="{{!empty($singledata->discount)? $singledata->discount:0}}" onkeyup="discountFun(this.value);">
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3" style="text-align: right"><b>Grand Total</b></td>
                      <td>
                        <input type="text" name="grand_total" class="form-control" id="grandTotal" value="0">
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3" style="text-align: right"><b>Paid Amount</b></td>
                      <td>
                        <input type="text" name="paid_amount" class="form-control" id="paidAmount" value="{{!empty($singledata->paid_amount)? $singledata->paid_amount:0}}" onkeyup="paidFun(this.value);">
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="3" style="text-align: right"><b>Due Amount</b></td>
                      <td>
                        <input type="text" class="form-control" id="dueAmount" value="0">
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

<script type="text/javascript">
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
    document.getElementById('subTotal').value = tot;
    document.getElementById('grandTotal').value = tot;
    document.getElementById('dueAmount').value = tot;
  }

  function discountFun(value) {
    var SubTotal = document.getElementById('subTotal').value;
    var DiscountAmount = (parseInt(SubTotal)*parseInt(value))/100;

    var AmountAfterDiscount = parseInt(SubTotal)-parseInt(DiscountAmount);

    if (isNaN(AmountAfterDiscount)) {
      document.getElementById('grandTotal').value = 0;
      document.getElementById('dueAmount').value = 0;
    }else{
      document.getElementById('grandTotal').value = AmountAfterDiscount;
      document.getElementById('dueAmount').value = AmountAfterDiscount;
    }
  }

  function paidFun(value) {
    var GrandTotal = document.getElementById('grandTotal').value;
    var DueAfterPaid = parseInt(GrandTotal)-parseInt(value);

    if (isNaN(DueAfterPaid)) {
      document.getElementById('dueAmount').value = 0;
    }else{
      document.getElementById('dueAmount').value = DueAfterPaid;
    }
  }
</script>
@endsection 