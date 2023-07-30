@extends('layouts.layout')
@section('title', 'Creat LC')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>Creat LC<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Creat LC</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> Creat LC</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['lc.store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4 form-group"> 
                <label>LC No <span class="text-danger">*</span></label>
                <input type="text" name="lc_no" class="form-control" value="" autocomplete="off" required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Bank<span class="text-danger">*</span></label>
                <select name="bank_id" class="form-control" required>
                  <option value="">Select One</option>
                  @foreach($allaccounts as $account)
                  <option value="{{$account->id}}">{{$account->bank_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Importer<span class="text-danger">*</span></label>
                <select name="importer_id" class="form-control" required>
                  <option value="">Select One</option>
                  @foreach($allimporter as $importer)
                  <option value="{{$importer->id}}">{{$importer->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Exporter<span class="text-danger">*</span></label>
                <select name="exporter_id" class="form-control" required>
                  <option value="">Select One</option>
                  @foreach($allsupplier as $supplier)
                  <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Origin Of Country</label>
                <input type="text" name="origin_of_country" class="form-control" value="" autocomplete="off" >
              </div>
              <div class="col-md-4 form-group"> 
                <label>Opening Date<span class="text-danger">*</span></label>
                <input type="text" name="opening_date" class="form-control datepicker" value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Expire Date<span class="text-danger">*</span></label>
                <input type="text" name="expire_date" class="form-control datepicker" value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Shipment Date<span class="text-danger">*</span></label>
                <input type="text" name="shipment_date" class="form-control datepicker" value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Border<span class="text-danger">*</span></label>
                <select name="border_id" class="form-control" required>
                  <option value="">Select One</option>
                  @foreach($allborder as $border)
                  <option value="{{$border->id}}">{{$border->name}}</option>
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
                        <th style="text-align: center">Product Type <span style="color: red">*</span></th>
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
                       
                    </tbody> 
                    <tfoot>
                      <tr> 
                        <td colspan="5" style="text-align: right"><b>{{ __('messages.row_total') }}  ($)</b></td>
                        <td>
                          <input type="text" name="sub_total" class="form-control bookSubTtlPrice" id="subTotal" value="100" readonly>
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();"><i class="fa fa-plus"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" style="text-align: right"><b>Dollar Rate (BDT)<span class="text-danger">*</span></b></td>
                        <td>
                            <input type="number" step="any" name="dollar_rate" class="form-control" id="dollarRate" onkeyup="calculate()" value="" autocomplete="off"  required>
                        </td>
                        <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>Total (BDT)<span class="text-danger">*</span></b></td>
                          <td>
                            <input type="number" step="any" name="total_bdt" class="form-control" id="totalInBDT" onkeyup="calculate()" value="" autocomplete="off"  required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>Margin (%)<span class="text-danger">*</span></b></td>
                          <td>
                            <input type="number" step="any" name="margin_percent" class="form-control" id="marginPercent" onkeyup="calculate()" value="" autocomplete="off"  required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>Margin Amount (BDT)<span class="text-danger">*</span></b></td>
                          <td> 
                            <input type="number" step="any" name="margin_amount" class="form-control" id="marginAmount" onkeyup="calculate()" value="" autocomplete="off"  required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>Bank Due<span class="text-danger">*</span></b></td>
                          <td> 
                            <input type="number" step="any" name="bank_due" class="form-control" id="bankDue" onkeyup="calculate()" value="" autocomplete="off" readonly required>
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>Commission (BDT)</b></td>
                          <td>
                            <input type="number" step="any" name="commission" class="form-control" id="commission" onkeyup="calculate()" value="" autocomplete="off">
                          </td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="5" style="text-align: right"><b>Insurance (BDT)</b></td>
                          <td> 
                            <input type="number" step="any" name="insurance" class="form-control" id="insurance" onkeyup="calculate()" value="" autocomplete="off" >
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
            <input type="submit" class="btn btn-success btn-sm" value="Create LC" onclick="return confirm('Are you sure?')" style="width: 15%; float: right; font-weight: bold">
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
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate()"><i class="fa fa-remove"></i></a>'; 
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
        var _bankDue=_totalInBDT-_marginAmount;
        $('#bankDue').val(_bankDue.toFixed(2));
    }
</script>
@endsection 