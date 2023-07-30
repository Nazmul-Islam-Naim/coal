@extends('layouts.layout')
@section('title', 'Pos Sell')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Add Customer</button>

  <a href="{{$baseUrl.'/'.config('app.sell').'/sell-report'}}" class="btn btn-success btn-sm"><i class="fa fa-list-alt"></i> Sell Report</a>
  <a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collection'}}" class="btn btn-success btn-sm"><i class="fa fa-list-alt"></i> Bill Collection</a>
  <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-sm"><i class="fa fa-list-alt"></i> Accounts</a>

  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Sell</li>
  </ol>
</section>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"/>
<style type="text/css">
  .card-sm {
    transition: box-shadow .3s;
    width: 100%; 
    border: 1px solid #ccc;; 
    background: #fff;
    cursor: pointer;
    border-radius: 5px; 
    margin-bottom: 10px;
    float: left;
  }
  .card-sm:hover {
    box-shadow: 0 0 11px rgba(33,33,33,.2); 
  }
</style>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.product') }} {{ __('messages.list') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row" style="height: 400px; overflow-y: scroll; margin: 0px;">
            <div class="col-md-12"> 
              <div class="form-group"> 
                <input type="text" onkeyup="searchProduct(this.value);" class="form-control fa" placeholder="&#xf002;">
              </div>
            </div>
            <div class="productList">
            @foreach($alldata as $data)
            <div class="col-md-4" onclick="getProductId(<?php echo $data->bar_code;?>);"> 
              <div class="card card-sm">
                <img class="card-img-top" src="{{asset('public/custom/img/no_product.png')}}" style="width: 100%;padding: 5px;">
                <div class="card-body">
                  <center><p class="card-text" style="font-weight: bold; font-size: 12px">{{$data->name}}</p></center>
                </div>
              </div>
            </div>
            @endforeach
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"> 
              
        </div>
      </div>
      <!-- /.box -->
    </div>

    <div class="col-md-8">
      <!-- <form class="ajax-form"> -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.product_detail') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-4"> 
              <div class="form-group"> 
                <input type="hidden" id="BarCode" class="form-control fa fa-2x" placeholder="&#xf02a;" value="" autocomplete="off">
                <input type="text" id="BarCodeOnly" class="form-control fa fa-2x" placeholder="&#xf02a;" value="" autocomplete="off">
              </div>
            </div>
            <form class="ajax-form">
            <div class="col-md-4"> 
              <div class="form-group"> 
                <input type="date" name="sell_date" class="form-control" value="<?php echo date('Y-m-d');?>" required="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <select class="form-control select2" required="" name="customer_id">
                  @foreach($allcustomer as $customer)
                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                  @endforeach
                </select>
                  <!-- <div class="col-md-4">
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal" style="font-size: 14px"><i class="fa fa-plus-circle"></i></button>
                  </div> -->
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive"> 
                <table class="table"> 
                  <thead> 
                    <tr>
                      <th style="text-align: center">{{ __('messages.item') }} <span style="color: red">*</span></th>
                      <th style="text-align: center">{{ __('messages.stock_qnty') }}</th>
                      <th style="text-align: center">{{ __('messages.quantity') }} <span style="color: red">*</span></th>
                      <th style="text-align: center">{{ __('messages.unit_price') }} <span style="color: red">*</span></th>
                      <th style="text-align: center">{{ __('messages.vat') }}</th>
                      <th style="text-align: center">{{ __('messages.row_total') }}</th>
                      <th style="text-align: center">{{ __('messages.action') }}</th> 
                    </tr> 
                  </thead>
                  <?php $row_num = 1; ?>
                  <tbody class="row_container"> 
                     
                  </tbody> 
                  <tfoot>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.row_total') }}</b></td>
                      <td>
                        <input type="text" name="sub_total" class="form-control" id="subTotal" value="0" readonly="">
                      </td>
                      <td></td>
                    </tr>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.discount_type') }}</b></td>
                      <td>
                        <select class="form-control" id="DiscountType">
                          <option value="percent">Percent</option>
                          <option value="amount">Amount</option>
                        </select>
                      </td>
                      <td></td>
                    </tr>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.discount') }}</b></td>
                      <td>
                        <input type="text" class="form-control" id="Discount" value="0" onkeyup="discountFun(this.value);" autocomplete="off">

                        <input type="hidden" name="discount" id="DiscountAmount" value="0">
                      </td>
                      <td></td>
                    </tr>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.vat') }}</b></td>
                      <td>
                        <input type="text" name="total_vat" class="form-control" id="totalVat" value="0" readonly="">
                      </td>
                      <td></td>
                    </tr>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.total') }}</b></td>
                      <td>
                        <input type="text" name="grand_total" class="form-control" id="grandTotal" value="0" readonly="">
                      </td>
                      <td></td>
                    </tr>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.paid_amount') }}</b></td>
                      <td>
                        <input type="text" name="paid_amount" class="form-control" id="paidAmount" value="0" onkeyup="paidFun(this.value);" autocomplete="off">
                      </td>
                      <td></td>
                    </tr>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.due_amount') }}</b></td>
                      <td>
                        <input type="text" class="form-control" id="dueAmount" value="0">
                      </td>
                      <td></td>
                    </tr>
                    <tr> 
                      <td colspan="5" style="text-align: right"><b>{{ __('messages.payment_method') }}</b></td>
                      <td>
                        <select class="form-control" name="payment_method">
                          @foreach($allbank as $bank)
                          <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                          @endforeach
                        </select>
                      </td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"> 
         <!--  <input type="submit" name="purchase" onclick="getSweetAlert();" class="btn btn-success pull-right" value="Save Sale">   -->
          <button class="btn btn-success btn-lg pull-right">Save Sale</button>    
        </div>
      </div>
      </form>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<!-- Customer Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> ADD CUSTOMER</h4>
      </div>
      <form class="ajax-customer-form">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group"> 
              <label>Name</label>
              <input type="text" name="name" class="form-control" value="" required>
            </div>
            <div class="form-group"> 
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="">
            </div>
            <div class="form-group"> 
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" value="" required>
            </div>
            <div class="form-group"> 
              <label>Address</label>
              <textarea name="address" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-success btn-sm" style="width: 15%">Save</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- ./Customer Modal -->

<!-- ./Customer Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('form.ajax-customer-form').on('submit', function (e) {
      e.preventDefault();
      //alert('Ok');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        //url: "{{URL::to('add-customer-via-pos-page')}}",
        url: "{{$baseUrl.'/'.config('app.customer').'/add-customer-via-pos-page'}}",
        data: $('form.ajax-customer-form').serialize(),
        dataType: "json",
        success:function(data) {
          console.log(data);
          $.each(data, function(key, value){
            $('select[name="customer_id"]').append('<option value="'+ value.id +'" selected="">' + value.name+ '</option>');
          });
          //$('#Customer').html(data);
          $('#myModal').modal('hide');
          swal("Yes!", "Customer Successfully Added.", "success");
        }
      });
      return false;
    });
  });

  function getProductId(productId) {
    //alert(productId);
    document.getElementById('BarCode').value = productId;
    $("#BarCode").click();
  }

  $(document).ready(function() {
    var RowNum = 0;
    var RowNums = 200;
    $('#BarCode').on('click', function() {
      var productId = $(this).val();
      //alert(productId);
      RowNum++;
      if(productId) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: "{{$baseUrl.'/'.config('app.sell').'/find-product-details-with-barcode'}}",
          data: {
            'id' : productId
          },
          dataType: "json",

          success:function(data) {
            //console.log(data);
            
            var html = "";
            //html += data;
            html += '<tr id="row_'+RowNum+'">';
            html += '<td><input type="text" class="form-control" value="'+data.name+'" readonly><input type="hidden" name="multiple['+RowNum+'][product_id]" value="'+data.id+'"></td>';
            html += '<td><input type="text" name="" class="form-control" value="'+data.quantity+'" readonly></td>';
            html += '<td><input type="text" name="multiple['+RowNum+'][quantity]" onkeyup="multiply('+RowNum+');" id="quantity_'+RowNum+'" class="form-control" value=""></td>';
            html += '<td><input type="text" name="multiple['+RowNum+'][unit_price]" onkeyup="multiply('+RowNum+');" id="rate_'+RowNum+'" class="form-control" value="'+data.price+'"><input type="hidden" value="'+data.vat_percent+'" id="vatpercent_'+RowNum+'"></td>';
            
            html += '<td><input type="text" name="vat[]" id="vatamount_'+RowNum+'" class="form-control" value="" readonly><input type="hidden" name="multiple['+RowNum+'][vat_amount]" id="totalvatamount_'+RowNum+'"></td>';
            html += '<td><input type="text" name="total[]" id="Total_'+RowNum+'" class="form-control" value="" readonly></td>';
            html +='<td><a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#row_'+RowNum+'\').remove();"><i class="fa fa-remove"></i></a></td>';
            html += '</tr>';

            $('.row_container').append(html);
          }
        });
      }else{
        $('.row_container').empty();
      }
    });

    //barcode only
    $('#BarCodeOnly').on('change', function(e) {
      var productId = $(this).val();
      //console.log(productId);

      RowNums++;
      if(productId) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: "{{$baseUrl.'/'.config('app.sell').'/find-product-details-with-barcode'}}",
          data: {
            'id' : productId
          },
          dataType: "json",

          success:function(data) {
            //console.log(data);
            
            if (Object.keys(data).length > 0) {
              var html = "";
              //html += data;
              html += '<tr id="row_'+RowNums+'">';
              html += '<td><input type="text" class="form-control" value="'+data.name+'" readonly><input type="hidden" name="multiple['+RowNums+'][product_id]" value="'+data.id+'"></td>';
              html += '<td><input type="text" name="" class="form-control" value="'+data.quantity+'" readonly></td>';
              html += '<td><input type="text" name="multiple['+RowNums+'][quantity]" onkeyup="multiply('+RowNums+');" id="quantity_'+RowNums+'" class="form-control" value=""></td>';
              html += '<td><input type="text" name="multiple['+RowNums+'][unit_price]" onkeyup="multiply('+RowNums+');" id="rate_'+RowNums+'" class="form-control" value="'+data.price+'"><input type="hidden" value="'+data.vat_percent+'" id="vatpercent_'+RowNums+'"></td>';
              html += '<td><input type="text" name="total[]" id="Total_'+RowNums+'" class="form-control" value=""></td>';
              html += '<td><input type="text" name="vat[]" id="vatamount_'+RowNums+'" class="form-control" value=""><input type="hidden" name="multiple['+RowNums+'][vat_amount]" id="totalvatamount_'+RowNums+'"></td>';
              html +='<td><a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#row_'+RowNums+'\').remove();"><i class="fa fa-remove"></i></a></td>';
              html += '</tr>';

              $('.row_container').append(html);
              $("#BarCodeOnly").val('');
              $("#BarCodeOnly").focus();
            }else{
              swal("Sorry!", "Product is Unavailable...", "error");
              $("#BarCodeOnly").val('');
              $("#BarCodeOnly").focus();
            }
          }
        });
      }else{
        $('.row_container').empty();
      }
    });
  });

  function multiply(RowNum){
    var qnty = document.getElementById('quantity_'+RowNum).value;
    var rate = document.getElementById('rate_'+RowNum).value;
    var total = parseFloat(qnty)*parseFloat(rate);

    var vatPercent = document.getElementById('vatpercent_'+RowNum).value;

    var vatAmount = parseFloat(total)*parseFloat(vatPercent)/100;

    if (isNaN(total)) {
      document.getElementById('Total_'+RowNum).value = 0;
      document.getElementById('vatamount_'+RowNum).value = 0;
      document.getElementById('totalvatamount_'+RowNum).value = 0;
    }else{
      document.getElementById('Total_'+RowNum).value = total;
      document.getElementById('vatamount_'+RowNum).value = vatAmount;
      document.getElementById('totalvatamount_'+RowNum).value = vatAmount;
    }

    // summation of total in total field

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

      var vatArr = document.getElementsByName('vat[]');
      var totVat=0;
      for(var i=0;i<vatArr.length;i++){
        if(parseFloat(vatArr[i].value))
          totVat += parseFloat(vatArr[i].value);
      }
      document.getElementById('totalVat').value = totVat;
      document.getElementById('grandTotal').value = parseFloat(tot)+parseFloat(totVat);
  }

  function discountFun(value) {
    var DiscountType = document.getElementById('DiscountType').value;
    var SubTotal = document.getElementById('subTotal').value;
    if (DiscountType=='percent') {
      var DiscountAmount = (parseFloat(SubTotal)*parseFloat(value))/100;
      var AmountAfterDiscount = parseFloat(SubTotal)-parseFloat(DiscountAmount);

      if (isNaN(AmountAfterDiscount)) {
        document.getElementById('grandTotal').value = 0;
        document.getElementById('dueAmount').value = 0;
        document.getElementById('DiscountAmount').value = 0;
      }else{
        var TotalVat = document.getElementById('totalVat').value;
        var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
        document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
      }
    }else if(DiscountType=='amount'){
      var DiscountAmount = parseFloat(value);
      var AmountAfterDiscount = parseFloat(SubTotal)-parseFloat(DiscountAmount);

      if (isNaN(AmountAfterDiscount)) {
        document.getElementById('grandTotal').value = 0;
        document.getElementById('dueAmount').value = 0;
        document.getElementById('DiscountAmount').value = 0;
      }else{
        var TotalVat = document.getElementById('totalVat').value;
        var FinalAmountAfterDiscount = parseFloat(AmountAfterDiscount)+parseFloat(TotalVat);
        document.getElementById('grandTotal').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('dueAmount').value = FinalAmountAfterDiscount.toFixed(2);
        document.getElementById('DiscountAmount').value = parseFloat(DiscountAmount).toFixed(2);
      }
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

  var productImage = "{{asset('public/custom/img/no_product.png')}}";
  function searchProduct(product) {
    //alert(product);
    if(product) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        //url: "{{URL::to('find-product-list-with-keyword')}}",
        url: "{{$baseUrl.'/'.config('app.sell').'/find-product-list-with-keyword'}}",
        data: {
          'id' : product
        },
        dataType: "json",

        success:function(data) {
          //console.log(data);
          $.each(data, function(key, value){
            //console.log(value.name);
          
            var html = "";
            html += '<div class="col-md-4" onclick="getProductId('+value.bar_code+');">';
            html += '<div class="card card-sm">';
            html += '<img class="card-img-top" src="'+productImage+'" style="width: 100%;padding: 5px;">';
            html += '<div class="card-body">';
            html += '<center><p class="card-text" style="font-weight: bold; font-size: 12px">'+value.name.substr(0, 12)+'</p></center>';
            html += '</div>';
            html += '</div>';
            html += '</div>';


            //html += value.name;
            //html += '<br>';

            $('.productList').html(html);
          });
        }
      });
    }else{
      var html = '<center><p>Product Not Found...</p></center>';
      $('.productList').html(html);
    }
  }

  $(document).ready(function() {
    $('form.ajax-form').on('submit', function (e) {
      e.preventDefault();
      //alert('Ok');
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        //url: "{{URL::to('save-sell-via-pos-page')}}",
        url: "{{$baseUrl.'/'.config('app.sell').'/save-sell-via-pos-page'}}",
        data: $('form.ajax-form').serialize(),
        dataType: "json",
        success:function(data) {
          console.log(data);
          $("form.ajax-form")[0].reset(); // resets the form
          
          if (data=='success') {
            var empty = '';
            $('.row_container').html(empty);

            swal({
              title: "Success!",
              text: "Do You Want To Print ?",
              type: "success",
              showCancelButton: true,
              confirmButtonColor: "#006400",
              confirmButtonText: "Yes",
              cancelButtonText: "NO",
              closeOnConfirm: false,
              closeOnCancel: true
            },function (isConfirm) {
              if (isConfirm) {
                //swal("Yes!", "There is your invoice Page.", "warning");
                //location.href = "https://www.w3schools.com";
                swal.close();
                $.ajax({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  method: "POST",
                  //url: "{{URL::to('print-invoice')}}",
                  url: "{{$baseUrl.'/'.config('app.sell').'/print-invoice'}}",
                  data: {'id': 1},
                  dataType: "json",
                  success: function (data) {
                    var html = '';
                    var subTotal = 0;
                    var vatTotal = 0;
                    var dicountTotal = 0;
                    var grandTotal = 0;

                    //console.log(data.total);

                    $.each(data, function(key, value){
                      //html += value.customer_id;
                      subTotal += parseFloat(value.quantity)*parseFloat(value.unit_price);
                      vatTotal += parseFloat(value.vat_amount);
                      dicountTotal = parseFloat(value.discount);

                      grandTotal = (parseFloat(subTotal)+parseFloat(vatTotal))-parseFloat(dicountTotal);

                      html += '<tr><td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">'+value.name+'</td><td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">'+value.quantity+'</td><td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">'+value.unit_price+'</td><td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">'+value.vat_amount+'</td><td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">'+value.quantity*value.unit_price+'</td></tr>';
                    });

                    var WindowObject = window.open("", "PrintWindow", "width=1360,height=768,top=0,left=0,toolbars=no,scrollbars=yes,status=no,resizable=yes");

                    WindowObject.document.write('<table width="100%"><tr><td width="85%"><center><h1><u>শুকরিয়া  মার্কেট</u></h1><p>জিন্দা বাজার, সিলেট</p></center></td></tr></table><br>');

                    WindowObject.document.write('<table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">');
                    WindowObject.document.write('<thead>');
                    WindowObject.document.write('<tr style="background: #ccc;" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">');
                    WindowObject.document.write('<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Product</th>');
                    WindowObject.document.write('<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quantity</th>');
                    WindowObject.document.write('<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Unit Price</th>');
                    WindowObject.document.write('<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Vat Amount</th>');
                    WindowObject.document.write('<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total</th>');
                    WindowObject.document.write('</tr>');
                    WindowObject.document.write('</thead>');
                    WindowObject.document.write('<tbody>');
                    WindowObject.document.writeln(html);
                    WindowObject.document.write('</tbody>');
                    WindowObject.document.write('<tfoot>');
                    WindowObject.document.write('<tr>');
                    WindowObject.document.write('<td colspan="4" style="text-align:right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Sub Total</td>');
                    WindowObject.document.write('<td style="text-align: left; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">');
                    WindowObject.document.writeln(subTotal);
                    WindowObject.document.write('</td>');
                    WindowObject.document.write('</tr>');

                    WindowObject.document.write('<tr>');
                    WindowObject.document.write('<td colspan="4" style="text-align:right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total Vat</td>');
                    WindowObject.document.write('<td style="text-align: left; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">');
                    WindowObject.document.writeln(vatTotal);
                    WindowObject.document.write('</td>');
                    WindowObject.document.write('</tr>');

                    WindowObject.document.write('<tr>');
                    WindowObject.document.write('<td colspan="4" style="text-align:right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total Discount</td>');
                    WindowObject.document.write('<td style="text-align: left; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">');
                    WindowObject.document.writeln(dicountTotal);
                    WindowObject.document.write('</td>');
                    WindowObject.document.write('</tr>');

                    WindowObject.document.write('<tr>');
                    WindowObject.document.write('<td colspan="4" style="text-align:right; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Grand Total</td>');
                    WindowObject.document.write('<td style="text-align: left; font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">');
                    WindowObject.document.writeln(grandTotal);
                    WindowObject.document.write('</td>');
                    WindowObject.document.write('</tr>');

                    WindowObject.document.write('</tfoot>');
                    WindowObject.document.write('</table>');
                    
                    WindowObject.document.close();
                    WindowObject.focus();
                    WindowObject.print();
                    WindowObject.close();
                  }         
                });
              }
            });
          }
        },
        error:function(data) {
          swal("Sorry!!!!!", "Something went Wrong.", "error");
        }
      });
      return false;
    });
  });
</script>
@endsection 