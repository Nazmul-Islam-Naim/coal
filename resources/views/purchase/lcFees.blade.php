@extends('layouts.layout')
@section('title', 'LC Fees Payment')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
  $row_num = 1;
  $subttl=0;
  $bank='';
  $date='';
  $note='';
?>
<section class="content-header">
  <h1>{{ __('messages.LC_fees_payment') }}<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.LC_fees_payment') }}</li>
  </ol>
</section>
<style type="text/css">
  .borderless td, .borderless th {
    border: none!important;
  }
</style>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i>LC Fees</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.purchase').'/lc'}}" class="btn btn-primary btn-xs pull-right"><i class="fa-list-alt"></i> <b>{{ __('messages.LC_list') }}</b></a>         
            </div>
            <!--<div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>-->
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12"> 
              <div class="table-responsive">
                <table class="table borderless">
                  <tbody>
                    <tr>
                      <td style="text-align: center;">
                        <form method="get" action="">
                        <div class="form-inline">
                          <div class="form-group">
                            <label>{{ __('messages.LC_No') }} : </label>
                            <input type="text" name="lcno" class="form-control" value="" required="" autocomplete="off">
                          </div>
                          <div class="form-group">
                            <input type="submit" value="Search" class="btn btn-success btn-md">
                          </div>
                        </div>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            @if(isset($_GET['lcno']))
            <div class="col-md-6 col-md-offset-3"> 
            @if(!empty($existsData) && count($existsData)!=0)
            {!! Form::open(array('route' =>['lc-fees.update',$single_data->id],'method'=>'PUT')) !!}
            @else
            {!! Form::open(array('route' =>['lc-fees.store'],'method'=>'POST')) !!}
            @endif
            @if($row==0)
            <center><h4 style="color: red"><i class="fa fa-warning"></i> {{$single_data}}</h4></center>
            @elseif($row==1)
            <div class="box box-primary">
              <div class="box-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{ __('messages.LC_No') }} <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" value="{{$single_data->lc_no}}" name="lc_no" required readonly>
                      <input type="hidden" value="{{$single_data->id}}" name="lc_id" required>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">{{ __('messages.add_fee_details') }}</div>
                            <div class="panel-body"> 
                                <div class="table-responsive"> 
                                    <table class="table"> 
                                        <thead> 
                                          <tr>
                                            <th style="text-align: center">{{ __('messages.Fee_Type_Name') }} <span style="color: red">*</span></th>
                                            <th style="text-align: center">{{ __('messages.amount') }}</th>
                                            <th style="text-align: center">{{ __('messages.action') }}</th> 
                                          </tr> 
                                        </thead>
                                        <tbody class="row_container"> 
                                            @if(!empty($existsData) && count($existsData)!=0)
                                                @foreach($existsData as $value)
                                                <tr id="div_{{$row_num}}">
                                                    <td> 
                                                    <select class="form-control select2" name="fee_details[{{$row_num}}][fees_type_id]" required="">
                                                        <option value="">--Select--</option>
                                                        @foreach (\App\Models\FeeType::all() as $value2)
                                                        <option value="{{$value2->id}}" {{($value->fees_type_id==$value2->id)?'selected':''}}>{{$value2->name}}</option>
                                                        @endforeach
                                                    </select> 
                                                    </td>
                                                    <td> 
                                                    <input type="number" step="any" name="fee_details[{{$row_num}}][amount]" class="form-control" id="amount_{{$row_num}}" onkeyup="calculate({{$row_num}})" value="{{$value->amount}}" required="" autocomplete="off"><input type="hidden" name="total[]" class="form-control" value="{{$value->amount}}" id="Total_{{$row_num}}"> 
                                                    </td>
                                                    <td> 
                                                    <a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$('#div_{{$row_num}}').remove();calculate()"><i class="fa fa-remove"></i></a> 
                                                    </td> 
                                                </tr>
                                                <?php $subttl += $value->amount; $bank=$value->bank_id; $date=$value->date; $note=$value->note; $row_num++;?>
                                                @endforeach
                                            @endif
                                        </tbody> 
                                        <tfoot>
                                            <tr> 
                                                <td colspan="" style="text-align: right"><b>{{ __('messages.row_total') }}</b></td>
                                                <td>
                                                  <input type="number" class="form-control" id="subTotal" value="{{$subttl}}" name="total_amount" required readonly>
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
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{__('messages.bank')}}<span class="text-danger">*</span></label>
                      <select name="bank_id" class="form-control" required>
                          <option value="">--Select--</option>
                          @foreach($allaccounts as $account)
                          <option value="{{$account->id}}" {{(!empty($bank) && ($bank==$account->id))?'selected':''}}>{{$account->bank_name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{__('messages.date')}} <span class="text-danger">*</span></label>
                      <input type="text" class="form-control datepicker" value="{{!empty($date)?$date:date('Y-m-d')}}" name="date" required>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="Group Name">{{__('messages.note')}} </label>
                      <textarea rows="1" class="form-control" value="{{!empty($note)?$note:''}}" name="note"></textarea>
                    </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success btn-md" onclick="return confirm('Are you sure?')">Payment</button>
              </div>
            </div>
            @endif
            {!! Form::close() !!}
            </div>
            @endif
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<?php
  $result = "";
  foreach (\App\Models\FeeType::all() as $value) {
    $result .= '<option value="'.$value["id"].'">'.$value["name"].'</option>';
  }
?>
<script type="text/javascript">
  function calculate(){
      var Cnf = $('#Cnf').val();
      var Duty = $('#Duty').val();
      var Other = $('#Other').val();
      var Interest = $('#Interest').val();
      var LabourCost = $('#LabourCost').val();
      if(isNaN(parseFloat(Cnf))){
          Cnf=0;
      }
      if(isNaN(parseFloat(Duty))){
          Duty=0;
      }
      if(isNaN(parseFloat(Interest))){
          Interest=0;
      }
      if(isNaN(parseFloat(Other))){
          Other=0;
      }
      if(isNaN(parseFloat(LabourCost))){
          LabourCost=0;
      }
      
      var _Total=parseFloat(Cnf)+parseFloat(Duty)+parseFloat(Other)+parseFloat(Interest)+parseFloat(LabourCost);
      $('#Total').val(_Total.toFixed(2));
  }
  
  // dynamic add more field
  var Result = '<?php echo $result;?>';
  var RowNum = '<?php echo $row_num;?>'; 
  function addrow(){  
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html +='<td>'; 
    html +='<select class="form-control select2" name="fee_details['+RowNum+'][fees_type_id]" required=""><option value="">--Select--</option>'+Result+'</select>'; 
    html +='</td>';
    html +='<td>'; 
    html +='<input type="number" step="any" name="fee_details['+RowNum+'][amount]" class="form-control" id="amount_'+RowNum+'" onkeyup="calculate('+RowNum+')" required="" autocomplete="off"><input type="hidden" name="total[]" class="form-control" id="Total_'+RowNum+'">'; 
    html +='</td>';
    html +='<td>'; 
    html +='<a href="javascript:0" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();calculate()"><i class="fa fa-remove"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
    $(".select2").select2({});
    RowNum++;
  }
  
  function calculate(RowNum){
    var amount = document.getElementById('amount_'+RowNum).value;

    if (isNaN(parseFloat(amount))) {
      document.getElementById('Total_'+RowNum).value = 0;
    }else{
      document.getElementById('Total_'+RowNum).value = amount;
    }

    // summation of total in total field

    var arr = document.getElementsByName('total[]');
    RowNum++;
    var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseFloat(arr[i].value))
              tot += parseFloat(arr[i].value);
      }
      document.getElementById('subTotal').value = tot;
  }
</script>
@endsection 