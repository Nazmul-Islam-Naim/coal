@extends('layouts.layout')
@section('title', 'Sell From Saved Quotation')
@section('content')
<!-- Content Header (Page header) -->
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
      <a href="{{$baseUrl.'/'.config('app.sell').'/sell-report'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Sale Report</a>
    </div>
    <div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.customer').'/customer'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Customers</a>
    </div>
    <div class="input-group">
      <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs"><i class="fa fa-list-alt"></i> Accounts</a>
    </div>
  </div>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Sell</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    {!! Form::open(array('route' =>['sell-saved-quotation'],'method'=>'POST')) !!}
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-exchange"></i> Sell From Saved Quotation</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
                <b>ID: {{$singlecustomer->customer_id}}&nbsp;&nbsp;||&nbsp;&nbsp;
                Name: {{$singlecustomer->name}}&nbsp;&nbsp;||&nbsp;&nbsp;
                Phone: {{$singlecustomer->phone}}&nbsp;&nbsp;||&nbsp;&nbsp;
                Address: {{$singlecustomer->address}}</b>
            </div>
            
            <div class="col-md-12">
              <div class="panel panel-primary">
                <div class="panel-heading">Car Basic Info</div>
                <div class="panel-body"> 
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                            <?php
                                $count = DB::table('product_sell')->orderBy('id', 'DESC')->first();
                                $invNo = "";
                                if(!empty($count->id)){
                                    $invNo = $count->id + 1;
                                }else{
                                    $invNo = '1';
                                }
                            ?>
                              <label>Job Card No</label>
                              <input type="text" name="job_card_no" value="{{date('Ymd')}}{{$invNo}}" class="form-control" autocomplete="off" readonly="">
                              <input type="hidden" name="customer_id" value="{{$singlecustomer->id}}">
                              <input type="hidden" name="tok" value="{{$singleData->tok}}">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Receive Date & Time</label>
                              <input type="datetime-local" name="receive_date_time" value="{{$singleData->receive_date_time}}" class="form-control datetimepicker" autocomplete="off">
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Delivery Date & Time</label>
                              <input type="datetime-local" name="delivery_date_time" value="{{$singleData->delivery_date_time}}" class="form-control datetimepicker" autocomplete="off">
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Reg No</label>
                              <input type="text" name="reg_no" class="form-control" value="{{$singleData->reg_no}}" autocomplete="off">
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label>Brand</label>
                              <input type="text" name="car_band" class="form-control" value="{{$singleData->car_band}}" autocomplete="off">
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label>Engine</label>
                              <input type="text" name="car_engine" class="form-control" value="{{$singleData->car_engine}}" autocomplete="off">
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label>VIN</label>
                              <input type="text" name="car_vin" class="form-control" value="{{$singleData->car_vin}}" autocomplete="off">
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label>Odometer</label>
                              <input type="text" name="car_odometer" class="form-control" value="{{$singleData->car_odometer}}" autocomplete="off">
                          </div>
                      </div>
                  </div>
                </div>
              </div>    
                
              <div class="panel panel-primary">
                <div class="panel-heading">Add Services</div>
                <div class="panel-body"> 
                  <div class="table-responsive"> 
                  <table class="table"> 
                    <thead> 
                      <tr>
                        <th style="text-align: center;">Job Code</th>
                        <th style="text-align: center;">Repair Instruction <span style="color: red">*</span></th>
                        <th style="text-align: center">Labour Cost <span style="color: red">*</span></th>
                        <th style="text-align: center">Technician <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.action') }}</th> 
                      </tr> 
                    </thead>
                    <?php $row_num = 0; $ttlServiceCost=0;?>
                    <tbody class="service_container"> 
                      @foreach($allservice as $data)
                      <?php $row_num++ ?>
                      <tr id="div_{{$row_num}}">
                        <td style="width: 10%"> 
                          <input type="text" class="form-control" value="J{{$row_num}}" readonly>
                        </td>
                        <td> 
                          <input type="text" name="service_details[{{$row_num}}][instruction]" value="{{$data->instruction}}" class="form-control" id="instruction_{{$row_num}}">
                        </td>
                        <td style="width: 20%"> 
                          <input type="number" step="any" name="service_details[{{$row_num}}][cost]" value="{{$data->cost}}" class="form-control" id="cost_{{$row_num}}" onkeyup="getallcost(<?php echo $row_num?>);" required="" autocomplete="off">
                        </td>
                        <td style="width: 20%">
                          <select name="service_details[{{$row_num}}][technician_id]" class="form-control select2" required=""> 
                            <option value="">Select</option>
                            @foreach($alltechnician as $technician)
                            <option value="{{$technician->id}}" {{($data->technician_id==$technician->id)?'selected':''}}>{{$technician->name}}</option>
                            @endforeach
                          </select>
                          <input type="hidden" name="servicetotal[]" value="{{$data->cost}}" class="form-control" id="ServiceTotal_{{$row_num}}" readonly="">
                        </td>
                        <td style="width: 10%">
                            <a href="{{URL::To('sells/delete-added-services-from-saved-quotation/'.$data->id.'/'.$singleData->tok)}}" onclick="return confirm('Want To Delete? This will not be Undone...')" class="btn btn-sm btn-danger pull-right"><i class="fa fa-remove"></i></a>
                        </td> 
                      </tr> 
                      <?php $ttlServiceCost += $data->cost;?>
                      @endforeach
                    </tbody> 
                    <tfoot>
                      <tr> 
                        <td colspan="2" style="text-align: right"><b>Sub Total</b></td>
                        <td>
                          <input type="text" name="sub_total" class="form-control" id="serviceSubTotal" value="{{$ttlServiceCost}}" readonly="">
                        </td>
                        <td>
                          <input type="number" step="any" name="vat_percent" value="{{$singleData->vat_percent}}" class="form-control" id="vatPercent" onkeyup="vatCalculate(this.value);" placeholder="Vat%" autocomplete="off">
                          <input type="hidden" id="vatPercentHidden" value="{{$singleData->vat_percent}}">
                          <input type="hidden" name="vat_amount" value="{{$singleData->vat_amount}}" id="vatAmount">
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addservice()"><i class="fa fa-plus"></i></a>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                </div>
              </div>
              
              <div class="panel panel-primary">
                <div class="panel-heading">Add Parts</div>
                <div class="panel-body"> 
                  <div class="table-responsive"> 
                  <table class="table"> 
                    <thead> 
                      <tr>
                        <th style="text-align: center; width: 20%">Parts Name <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.stock_qnty') }}</th>
                        <th style="text-align: center">{{ __('messages.quantity') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.unit_price') }} <span style="color: red">*</span></th>
                        <th style="text-align: center">{{ __('messages.row_total') }}</th>
                        <th style="text-align: center">{{ __('messages.action') }}</th> 
                      </tr> 
                    </thead>
                    <?php $row_num2 = 0; $ttlPartsCost=0;?>
                    <tbody class="parts_container"> 
                      @foreach($allproduct as $data)
                      <?php $row_num2++ ?>
                      <tr id="div2_{{$row_num2}}"> 
                        <td style="width: 20%">
                          <select name="parts_details[{{$row_num2}}][product_id]" class="form-control select2" onchange="getProductDetails(this.value, <?php echo $row_num2?>);" required=""> 
                            <option value="">Select</option>
                            @foreach($alldata as $product)
                            <option value="{{$product->id}}" {{($data->product_id==$product->id)?'selected':''}}>{{$product->name}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td> 
                          <?php 
                            $productInfo = DB::table('stock_product')->where('product_id', $data->product_id)->first();
                          ?>
                          <input type="text" class="form-control" id="stockqnty_{{$row_num2}}" value="{{$productInfo->quantity}}" readonly>
                        </td>
                        <td> 
                          <input type="number" step="any" name="parts_details[{{$row_num2}}][quantity]" value="{{$data->quantity}}" class="form-control" id="quantity_{{$row_num2}}" onkeyup="multiply(<?php echo $row_num2?>);" required="" autocomplete="off">
                        </td>
                        <td> 
                          <input type="number" step="any" name="parts_details[{{$row_num2}}][unit_price]" value="{{$data->unit_price}}" class="form-control" id="rate_{{$row_num2}}" onkeyup="multiply(<?php echo $row_num2?>);" required="" autocomplete="off">
                          <input type="hidden" name="parts_details[{{$row_num2}}][purchase_value]" value="{{$data->purchase_value}}" id="purchaserate_<?php echo $row_num2?>">
                        </td>
                        <td> 
                          <input type="text" name="partstotal[]" value="{{$data->quantity*$data->unit_price}}" class="form-control" id="PartTotal_{{$row_num2}}" readonly="">
                        </td>
                        <td>
                            <a href="{{URL::To('sells/delete-added-parts-from-saved-quotation/'.$data->product_id.'/'.$singleData->tok)}}" onclick="return confirm('Want To Delete? This will not be Undone...')" class="btn btn-sm btn-danger pull-right"><i class="fa fa-remove"></i></a>
                        </td>
                      </tr> 
                      <?php $ttlPartsCost += $data->quantity*$data->unit_price;?>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr> 
                        <td colspan="4" style="text-align: right"><b>Sub Total</b></td>
                        <td>
                          <input type="text" name="sub_total" class="form-control" id="partSubTotal" value="{{$ttlPartsCost}}" readonly="">
                        </td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addparts()"><i class="fa fa-plus"></i></a>
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
        <div class="box-footer" style="padding: 0px;">
            <div class="text-right" style="position: sticky;bottom: 0;background: #337ab7;padding: 25px 75px 0px 75px;">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group" style="margin-top: -20px;">
                      <label for="subTotal" style="color: #fff">Total Amount</label>
                      <input type="number" name="total_amount" class="form-control" id="TotalAmount" value="{{$singleData->total_amount}}" required="" readonly="">
                      <input type="hidden" id="HiddenTotalAmount" value="{{$singleData->total_amount}}">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group" style="margin-top: -20px;">
                      <label for="Discount" style="color: #fff">Advance</label>
                      <input type="number" class="form-control" name="advance" id="Advance" value="0" onkeyup="advanceFun(this.value);" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group" style="margin-top: -20px;">
                      <label style="color: #fff">Due</label>
                      <input type="number" id="dueAmount" class="form-control" value="{{$singleData->total_amount}}" readonly="">
                    </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group" style="margin-top: -20px;"> 
                        <label style="color: #fff">Payment Type <span style="color: red">*</span></label>
                        <select class="form-control select2" name="payment_method" required=""> 
                          <option value="">Select</option>
                          @foreach($allbank as $bank)
                          <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="submit" name="purchase" class="btn btn-md btn-warning" value="Save Sell" style="padding: 10px 50px;font-weight: bold">
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
      <!-- /.box -->
    </div>
    {!! Form::close() !!}
  </div>
</section>
<!-- /.content -->

<?php
  $result = "";
  foreach ($alltechnician as $technician) {
    $result .= '<option value="'.$technician->id.'">'.$technician->name.'</option>';
  }
  
  $result2 = "";
  foreach ($alldata as $value) {
    $result2 .= '<option value="'.$value->id.'">'.$value->name.'</option>';
  }
?>

<script type="text/javascript">
  // dynamic add more field
  var Result = '<?php echo $result;?>';
  var RowNum = '<?php echo $row_num;?>'; 
  var RowNum2 = '<?php echo $row_num2;?>'; 
  function addservice(){ 
    RowNum++; 
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html += '<td style="width: 10%">';
    html += '<input type="text" class="form-control" value="J'+RowNum+'" readonly>';
    html += '</td>';
    html += '<td>'; 
    html += '<input type="text" name="service_details['+RowNum+'][instruction]" class="form-control" id="instruction_'+RowNum+'" required="" autocomplete="off">';
    html += '</td>';
    html += '<td style="width: 20%">'; 
    html += '<input type="number" step="any" name="service_details['+RowNum+'][cost]" class="form-control" id="cost_'+RowNum+'" onkeyup="getallcost('+RowNum+')" required="" autocomplete="off">';
    html += '</td>';
    html += '<td style="width: 20%">';
    html += '<select class="form-control select2" name="service_details['+RowNum+'][technician_id]" required=""><option value="">Select</option>'+Result+'</select>';
    html += '<input type="hidden" name="servicetotal[]" value="0" class="form-control" id="ServiceTotal_'+RowNum+'" readonly="">';
    html += '</td>';
    html +='<td>'; 
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate();"><i class="fa fa-remove"></i></a>'; 
    html +='</td>';
    html +='</tr>';
    $('.service_container').append(html);
    $('.select2').select2();
  }
  
  var Result2 = '<?php echo $result2;?>';
  function addparts(){ 
    RowNum2++; 
    var html = ""; 
    html += '<tr id="div2_'+RowNum2+'">';
    html +='<td>'; 
    html +='<select class="form-control select2" onchange="getProductDetails(this.value, '+RowNum2+')" name="parts_details['+RowNum2+'][product_id]" required=""><option value="">Select</option>'+Result2+'</select>'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" class="form-control" id="stockqnty_'+RowNum2+'" readonly>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" step="any" name="parts_details['+RowNum2+'][quantity]" class="form-control" id="quantity_'+RowNum2+'" onkeyup="multiply('+RowNum2+');" required="" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="number" step="any" name="parts_details['+RowNum2+'][unit_price]" class="form-control" id="rate_'+RowNum2+'" onkeyup="multiply('+RowNum2+');" required="" autocomplete="off"><input type="hidden" name="parts_details['+RowNum2+'][purchase_value]" value="" id="purchaserate_'+RowNum2+'"'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" name="partstotal[]" class="form-control" id="PartTotal_'+RowNum2+'" readonly="">'; 
    html +='</td>';
    html +='<td>'; 
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div2_'+RowNum2+'\').remove();calculate();"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.parts_container').append(html);
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
        //$('#vatpercent_'+RowNums).val(data.vat_percent);
        $('#stockqnty_'+RowNums).val(data.quantity);
        $('#purchaserate_'+RowNums).val(data.unit_price);
      }
    });
  }
  
  function calculate() {
    // get all parts info
    var arr = document.getElementsByName('partstotal[]');
    var tot=0;
    for(var i=0;i<arr.length;i++){
      if(parseInt(arr[i].value))
        tot += parseInt(arr[i].value);
    }
    document.getElementById('partSubTotal').value = tot;
    document.getElementById('TotalAmount').value = tot;
    document.getElementById('HiddenTotalAmount').value = tot;
    
    // get all service info
    var arr = document.getElementsByName('servicetotal[]');
    var tot2=0;
    for(var i=0;i<arr.length;i++){
      if(parseInt(arr[i].value))
        tot2 += parseInt(arr[i].value);
    }
    document.getElementById('serviceSubTotal').value = tot2;
    document.getElementById('TotalAmount').value = tot2+tot;
    document.getElementById('HiddenTotalAmount').value = tot2+tot;
    
    // get service vat
      var partsTTlAmount = document.getElementById('partSubTotal').value;
      // calculate vat
      var vatPercent = document.getElementById('vatPercent').value;
      var VatAmount = vatPercent*tot2/100;
      document.getElementById('vatAmount').value = VatAmount;
      
      document.getElementById('TotalAmount').value = tot2+tot+VatAmount;
      document.getElementById('HiddenTotalAmount').value = tot2+tot+VatAmount;
    
    // calculate due
    var TTlAdvance = document.getElementById('Advance').value;
    var TTlAmount = document.getElementById('HiddenTotalAmount').value;
    document.getElementById('dueAmount').value = parseFloat(TTlAmount)-parseFloat(TTlAdvance);
  }

  function multiply(RowNum2){
    var StockQnty = document.getElementById('stockqnty_'+RowNum2).value;
    var qnty = document.getElementById('quantity_'+RowNum2).value;
    var rate = document.getElementById('rate_'+RowNum2).value;
    if(parseInt(qnty)>parseInt(StockQnty)){
        alert('Input Quantity Must be Samller or Equal of Stock Quantity');
        document.getElementById('quantity_'+RowNum2).value = '0';
        
        document.getElementById('PartTotal_'+RowNum2).value = 0;
        document.getElementById('partSubTotal').value = 0;
    }else{
    var total = parseFloat(qnty)*parseFloat(rate);


    if (isNaN(total)) {
      document.getElementById('PartTotal_'+RowNum2).value = 0;
    }else{
      document.getElementById('PartTotal_'+RowNum2).value = total.toFixed(2);
    }

    // summation of total in total field

    var arr = document.getElementsByName('partstotal[]');
    RowNum2++;
    var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseFloat(arr[i].value))
              tot += parseFloat(arr[i].value);
      }
      document.getElementById('partSubTotal').value = tot;
      
      // get service total amount
      var serviceTTlAmount = document.getElementById('serviceSubTotal').value;
      var vatTTlAmount = document.getElementById('vatAmount').value;
      document.getElementById('HiddenTotalAmount').value = parseFloat(tot)+parseFloat(serviceTTlAmount)+parseFloat(vatTTlAmount);
      document.getElementById('TotalAmount').value = parseFloat(tot)+parseFloat(serviceTTlAmount)+parseFloat(vatTTlAmount);
      
      var TTlAdvance = document.getElementById('Advance').value;
      var TTlAmount = document.getElementById('HiddenTotalAmount').value;
      document.getElementById('dueAmount').value = parseFloat(TTlAmount)-parseFloat(TTlAdvance);
    }
  }
  
  function getallcost(RowNum){
    var Cost = document.getElementById('cost_'+RowNum).value;

    if (isNaN(Cost)) {
      document.getElementById('ServiceTotal_'+RowNum).value = 0;
    }else{
      document.getElementById('ServiceTotal_'+RowNum).value = Cost;
    }
    
    // summation of total in total field

    var arr = document.getElementsByName('servicetotal[]');
    RowNum2++;
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('serviceSubTotal').value = tot;
    
    // get service total amount
      var partsTTlAmount = document.getElementById('partSubTotal').value;
      // calculate vat
      var vatPercent = document.getElementById('vatPercent').value;
      var VatAmount = vatPercent*tot/100;
      
      document.getElementById('vatAmount').value = VatAmount;
      document.getElementById('HiddenTotalAmount').value = parseFloat(tot)+parseFloat(partsTTlAmount)+parseFloat(VatAmount);
      document.getElementById('TotalAmount').value = parseFloat(tot)+parseFloat(partsTTlAmount)+parseFloat(VatAmount);
      
      var TTlAdvance = document.getElementById('Advance').value;
      var TTlAmount = document.getElementById('HiddenTotalAmount').value;
      document.getElementById('dueAmount').value = parseFloat(TTlAmount)-parseFloat(TTlAdvance);
  }
  
  function vatCalculate(value){
      document.getElementById('vatPercentHidden').value = value;
      var serviceTTlAmount = document.getElementById('serviceSubTotal').value;
      var VatAmount = value*serviceTTlAmount/100;
      document.getElementById('vatAmount').value = parseFloat(VatAmount);
      
      var partsTTlAmount = document.getElementById('partSubTotal').value;
      document.getElementById('HiddenTotalAmount').value = parseFloat(serviceTTlAmount)+parseFloat(partsTTlAmount)+parseFloat(VatAmount);
      document.getElementById('TotalAmount').value = parseFloat(serviceTTlAmount)+parseFloat(partsTTlAmount)+parseFloat(VatAmount);
      
      var TTlAdvance = document.getElementById('Advance').value;
      var TTlAmount = document.getElementById('HiddenTotalAmount').value;
      document.getElementById('dueAmount').value = parseFloat(TTlAmount)-parseFloat(TTlAdvance);
  }

  function advanceFun(value) {
    var GrandTotalHidden = document.getElementById('HiddenTotalAmount').value;
    
      var AmountAfterAdvance = parseFloat(GrandTotalHidden)-parseFloat(value);
      if (isNaN(AmountAfterAdvance)) {
        document.getElementById('dueAmount').value = 0;
      }else{
        document.getElementById('dueAmount').value = AmountAfterAdvance.toFixed(2);
      }
  }
</script>
@endsection