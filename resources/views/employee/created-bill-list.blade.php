@extends('layouts.layout')
@section('title', 'Employee Bill List')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Employee Bill List <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Employee Bill List</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> Employee Bill List</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">Employee Bill List</h4></center>
              <div class="table-responsive">
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Employee</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->name}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Employee ID</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->employee_id}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.email') }}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->email}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.phone') }}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->phone}}</td>
                    </tr>
                  </thead>
                </table>
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Month</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Year</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Note</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Bill Amount</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Paid Amount</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Action</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $credit = 0;
                      $debit = 0;
                      $sumBill = 0;
                      $sumPaid = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                      ?>
                      @if($data->amount != $data->paid_amount)
                      <?php $sumBill += $data->amount; $sumPaid += $data->paid_amount;?>
                    <tr>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->month_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->year_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->amount}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->paid_amount}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#createBill_{{$data->id}}" class="btn btn-sm btn-success">Pay Bill</a>
                        
                        <!-- Start Modal for salary -->
                        <div id="createBill_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Pay Bill #{{$data->id}}</h4>
                              </div>

                              {!! Form::open(array('route' =>['store-employee-salary'],'method'=>'POST')) !!}
                              <div class="modal-body">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                     <div class="form-group"> 
                                        <label>Payable Amount</label>
                                        <input type="hidden" name="employee_id" value="{{$data->employee_id}}">
                                        <input type="hidden" name="bill_id" value="{{$data->id}}">
                                        <input type="hidden" name="month" value="{{$data->month_name}}">
                                        <input type="hidden" name="year" value="{{$data->year_name}}">
                                        <input type="hidden" name="emp_name" value="{{$singledata->name}}">
                                        <input type="number" class="form-control" value="{{$data->amount - $data->paid_amount}}" autocomplete="off" readonly>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                     <div class="form-group"> 
                                        <label>Given Amount</label>
                                        <input type="number" name="amount" class="form-control" value="{{$data->amount - $data->paid_amount}}" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <label>Payment Method</label>
                                      <select class="form-control select2" name="bank_id" required="">
                                        <option value="">Select</option>
                                        @foreach(\App\Models\BankAccount::all() as $bank)
                                        <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="col-md-12">
                                     <div class="form-group"> 
                                        <label>Date</label>
                                        <input type="text" class="form-control datepicker" name="date" value="{{date('Y-m-d')}}" required="" autocomplete="off">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                     <div class="form-group"> 
                                        <label>Note <span style="font-size: 10px; color: red">(only 15 Character)</span></label>
                                        <input type="text" class="form-control" maxlength="15" name="note" value="" autocomplete="off">
                                      </div>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                {{Form::submit('Save',array('class'=>'btn btn-success btn-sm', 'style'=>'width:15%'))}}
                              </div>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                        <!-- End Modal for salary -->
                      </td>
                    </tr>
                    @endif
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="6" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                      <tr>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px; text-align: right" colspan="5">Total</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{Session::get('currency')}} {{number_format($sumBill, 2)}}</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{Session::get('currency')}} {{number_format($sumPaid, 2)}}</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"></td>
                      </tr>
                  </tfoot>
                  <tfoot>
                    
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                    {{$alldata->render()}}
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
  </div>
</section>
<!-- /.content -->

<script type="text/javascript">
  <?php
    $siteInfo = DB::table('site_setting')->where('id', 1)->first();
    $header = '';
    $logo = '';
    if (!empty($siteInfo)) {
      $logo = '../public/storage/app/public/uploads/logo/'.$siteInfo->image;

      $header = '<td width="20%"><img src="'.$logo.'" width="70px" height="70px"></td><td width="80%"><center><h3 style="margin:0; padding:0; margin-bottom: 0px">'.$siteInfo->company_name.'</h3>'.$siteInfo->address.'<br> Mobile : '.$siteInfo->phone.', Email : '.$siteInfo->email.'</center></td>';
    }
  ?>

  function PrintElem(elem)
  {
    Popup($(elem).html());
  }

  function Popup(data) 
  {   
    var mywindow = window.open('', 'my div', 'height=1000,width=1000');
    var is_chrome = Boolean(mywindow.chrome);
    mywindow.document.write('<html><head><title>Binary IT</title><style>a {text-decoration:none;}</style>');

    var Header = '<?php echo $header;?>';

    mywindow.document.write('<table width="80%" style="margin-left: auto; margin-right: auto"><tr>'+Header+'</tr></table><br>');
    
    mywindow.document.write('</head><body>');
    mywindow.document.write('<center><u><span style="font-weight: bold; font-size: 15px">Customer Ledger</span></u><center>');    
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
      
    if (is_chrome) {
      setTimeout(function() { // wait until all resources loaded 
      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10
      mywindow.print(); // change window to winPrint
      mywindow.close(); // change window to winPrint
      }, 500);
    } else {
      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10

      mywindow.print();
      mywindow.close();
    }
    return true;
  }
</script>
@endsection 