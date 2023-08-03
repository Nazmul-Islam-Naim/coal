@extends('layouts.layout')
@section('title', 'Customer Ledger')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.customer_ledger') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.customer_ledger') }}</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.customer_ledger') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <div style="right:0;margin-right:20px;" id="print_icon"><a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("custom/img/print.png")}}'></a></div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
              <div class="col-md-4">
                 {{  Form::open(array('route' => ['customer-ledger-document-upload',request()->id], 'method' => 'POST', 'files' => true))  }}
                    <div class="form-group">
                        <label>Upload Document</label>
                        <input type="file" class="form-control" name="documents" accept=".pdf">
                        <input type="hidden" name="customer_id" value="{{request()->id}}">
                        <input type="submit" value="Save" class="btn btn-success btn-md" onclick="return confirm('Are you sure?')">
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-12"> 
              <div class="table-responsive">
                <table class="table borderless">
                  <tbody>
                    <tr>
                      <td style="text-align: center;">
                        <form method="post" action="{{ route('customer-ledger.filter', $singledata->id) }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <div class="form-inline">
                            <div class="form-group">
                              <label>From : </label>
                              <input type="text" name="start_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                              <label>To : </label>
                              <input type="text" name="end_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off">
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
              </div>
            </div>
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">{{ __('messages.customer_ledger') }}</h4></center>
              <div class="table-responsive">
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.customer') }}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.customer') }} {{ __('messages.id') }}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->customer_id}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.company_name') }}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->company}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.phone') }}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->phone}}</td>
                    </tr>
                  </thead>
                </table>
                <br>
                <?php
                    $countDocumt=DB::table('uploaded_documents')->where('customer_id', request()->id)->get();
                    foreach($countDocumt as $docs){
                ?>
                     <a target="_blank" href="/development_coal_tamabil/storage/app/public/uploads/documents/<?php echo $docs->name?>" style="background: gray;color: #000; padding: 10px">View Documents</a>
                <?php 
                    }
                ?>
                <br>
                <br>
                @if(!empty($start_date) && !empty($end_date))
                  <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
                @else
                  <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
                @endif
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <!--<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Bank Account</th>-->
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.reason') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Truck No</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Rate</th>
                      <!--<th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.reason') }}</th>-->
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.note') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.bill') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.pay') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.balance') }}</th>
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
                      $sum = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                      ?>
                    <tr>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                          <?php
                          $reasons = $data->reason;
                          ?>
                          
                          @if(!empty($data->bank_id))
                          {{$data->ledger_bank_object->bank_name}}
                          @endif
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->truck_no}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->quantity}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->unit_price}}</td>
                      <!--<td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <?php
                          //$reasons = $data->reason;

                          if(preg_match("/sell/", $reasons)) {
                            echo $data->amount;
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }elseif(preg_match("/pre due/", $reasons)) {
                            echo $data->amount;
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <?php
                          $reasons = $data->reason;

                          if(preg_match("/receive/", $reasons)) {
                            echo $data->amount;
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }elseif(preg_match("/adjustment/", $reasons)) {
                            echo $data->amount;
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{Session::get('currency')}} {{number_format($sum, 2)}}</td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="10" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
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