@extends('layouts.layout')
@section('title', 'Employee Bill List')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.all_bill_list') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.all_bill_list') }}</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.all_bill_list') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <table class="table borderless">
              <tbody>
                <tr>
                  <td style="text-align: center;">
                    <form method="post" action="{{ route('all-bill-list.filter') }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-inline">
                        <div class="form-group">
                         <!-- <label>{{ __('messages.employee') }} : </label>-->
                          <input type="text" name="input" class="form-control" value="">
                        </div>
                        <div class="form-group">
                          <input type="submit" name="search" value="Search" class="btn btn-success btn-md">
                        </div>
                      </div>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
              
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">{{ __('messages.all_bill_list') }}</h4></center>
              <div class="table-responsive">
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.name') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.Month') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.Year') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.note') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.bill') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.paid_amount') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.action') }}</th>
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
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->bill_employee_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->month_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->year_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->amount}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->paid_amount}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#createBill_{{$data->id}}" class="btn btn-sm btn-success">Pay Bill</a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#editBill_{{$data->id}}" class="btn btn-sm btn-primary">Edit Bill</a>
                        
                        <!-- Start Modal for salary -->
                        <div id="createBill_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Pay Bill #{{$data->bill_employee_object->name}}, {{$data->month_name}} - {{$data->year_name}}</h4>
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
                                        <input type="hidden" name="emp_name" value="{{$data->bill_employee_object->name}}">
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
                        
                        <!-- Start Modal for edit bill -->
                        <div id="editBill_{{$data->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Pay Bill #{{$data->bill_employee_object->name}}, {{$data->month_name}} - {{$data->year_name}}</h4>
                              </div>

                              {!! Form::open(array('route' =>['update-bill-amount',$data->id],'method'=>'PUT')) !!}
                              <div class="modal-body">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                     <div class="form-group"> 
                                        <label>Amount</label>
                                        <input type="number" class="form-control" name="amount" value="{{$data->amount}}" autocomplete="off">
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
                        <!-- End Modal for edit bill -->
                      </td>
                    </tr>
                    @endif
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="9" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                      <tr>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px; text-align: right" colspan="6">Total</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{Session::get('currency')}} {{number_format($sumBill, 2)}}</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{Session::get('currency')}} {{number_format($sumPaid, 2)}}</td>
                          <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"></td>
                      </tr>
                  </tfoot>
                  <tfoot>
                    
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
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