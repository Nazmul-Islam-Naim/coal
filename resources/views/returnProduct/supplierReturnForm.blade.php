@extends('layouts.layout')
@section('title', 'Supplier Return Form')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.sell_return_to_supplier') }} <small></small> </h1>
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
          <h3 class="box-title"> <i class="fa fa fa-retweet"></i> {{ __('messages.sell_return_to_supplier') }}</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['supplier-return-from-submit.store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <th colspan="3">{{ __('messages.supplier') }}</th>
                      <th colspan="3">{{$singledata->productpurchase_supplier_object->name}}</th>
                      <input type="hidden" name="supplier_id" value="{{$singledata->supplier_id}}">
                      <input type="hidden" name="tok" value="{{$singledata->tok}}">
                    </tr>
                    <tr> 
                      <th colspan="3">{{ __('messages.invoice') }}</th>
                      <th colspan="3">{{$singledata->tok}}</th>
                    </tr>
                  </thead>
                </table>

                <table class="table table-bordered table-striped table-responsive table-hover">
                  <thead> 
                    <tr> 
                      <th width="20%">{{ __('messages.item_information') }}</th>
                      <th width="10%">{{ __('messages.sold_qnty') }}</th>
                      <th width="10%">{{ __('messages.return_qnty') }} <span style="color: red">*</span></th>
                      <th width="20%">{{ __('messages.unit_price') }}</th>
                      <th width="20%">{{ __('messages.deduction_amount') }} %</th>
                      <th width="20%">{{ __('messages.row_total') }}</th>
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
                      </td>
                      <td>{{$data->quantity}}</td>
                      <td> 
                        <input type="number" step="any" name="multidata[<?php echo $rowCount?>][return_qnty]" class="form-control" id="RQnty_{{$rowCount}}" value="" onkeyup="multiply(<?php echo $rowCount?>);" required="" autocomplete="off">
                      </td>
                      <td> 
                        <input type="number" step="any" name="multidata[<?php echo $rowCount?>][rate]" class="form-control" id="Rate_{{$rowCount}}" value="{{$data->unit_price}}" readonly="" onkeyup="multiply(<?php echo $rowCount?>);" autocomplete="off">
                      </td>
                      <td> 
                        <input type="number" step="any" name="multidata[<?php echo $rowCount?>][deduction_percent]" class="form-control" id="Deduction_{{$rowCount}}" value="0" onkeyup="deductionCal(<?php echo $rowCount?>);" autocomplete="off">

                        <input type="hidden" name="deduction_amount[]" id="Deduction_amount_{{$rowCount}}" value="0">
                      </td>
                      <td> 
                        <input type="number" step="any" name="multidata[<?php echo $rowCount?>][total_amount]" class="form-control" id="Total_{{$rowCount}}" value="" readonly="">

                        <input type="hidden" name="total[]" id="Total_Hidden_{{$rowCount}}" value="">
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr> 
                      <td colspan="4" rowspan="3">
                        <center><label for="details" class="  col-form-label text-center">{{ __('messages.reason') }}</label></center>
                        <textarea class="form-control" name="details" id="details" placeholder="Reason"></textarea> <br>
                        <label>{{ __('messages.usability') }} </label><br>
                        <label><input type="radio" checked="checked" name="usability" value="1"> Adjust With Stock</label>
                      </td>
                      <td style="text-align:right">{{ __('messages.deduction_amount') }} :</td>
                      <td> 
                        <input type="number" step="any" name="total_deduction" id="totalDeduction" class="form-control" value="0" autocomplete="off">
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:right">{{ __('messages.vat') }} :</td>
                      <td> 
                        <input type="text" name="total_vat" class="form-control" value="{{$singledata->total_vat}}" readonly="">
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:right">{{ __('messages.return_amount') }} :</td>
                      <td> 
                        <input type="text" name="total_return_amount" id="totalReturnAmount" class="form-control" value="" readonly="">
                      </td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                  <button type="submit" class="btn btn-success btn-sm">Return</button>
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
  }

  function deductionCal(RowNum) {
    var Total = document.getElementById('Total_Hidden_'+RowNum).value;
    var DeductPercent = document.getElementById('Deduction_'+RowNum).value;

    var DeductAmnt = parseFloat(Total)*parseFloat(DeductPercent)/100;
    document.getElementById('Deduction_amount_'+RowNum).value = DeductAmnt.toFixed(2);

    var FinalTotal = parseFloat(Total)-parseFloat(DeductAmnt);
    if (isNaN(FinalTotal)) {
      document.getElementById('Total_'+RowNum).value = 0;
      document.getElementById('Total_Hidden_'+RowNum).value = 0;
    }else{
      document.getElementById('Total_'+RowNum).value = FinalTotal.toFixed(2);
      document.getElementById('Total_Hidden_'+RowNum).value = FinalTotal.toFixed(2);
    }

    var arr = document.getElementsByName('deduction_amount[]');
    var tot=0;
    for(var i=0;i<arr.length;i++){
      if(parseInt(arr[i].value))
        tot += parseInt(arr[i].value);
    }
    document.getElementById('totalDeduction').value = tot;

    var array = document.getElementsByName('total[]');
    var total=0;
    for(var i=0;i<array.length;i++){
      if(parseInt(array[i].value))
        total += parseFloat(array[i].value);
    }
    document.getElementById('totalReturnAmount').value = total;   
  }
</script>
@endsection 