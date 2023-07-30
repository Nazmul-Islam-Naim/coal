@extends('layouts.layout')
@section('title', 'Bank Report')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.bank_report') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <!-- <h4 class="box-title"> BANK DETAIL</h4> -->
          <!--<a href="javascript:void(0)" onclick="PrintElem('#mydiv')" class="btn btn-info btn-sm pull-right"><i class="fa fa-print"></i></a>-->
          <a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:40px;" src='{{asset("public/custom/img/print.png")}}'></a>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body">
          <div class="row">
            <div class="col-md-12"> 
              <div class="table-responsive">
                <div class="col-md-12" style="text-align: center;">
                  <form method="post" action="{{ route('bank-report.filter', $singledata->id) }}" autocomplete="off">
                  @csrf
                  <div class="form-inline">
                    <div class="form-group">
                      <label>From : </label>
                      <input type="text" name="start_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label>To : </label>
                      <input type="text" name="end_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                      <input type="hidden" name="bank_id" value="{{$singledata->id}}">
                    </div>
                    <div class="form-group">
                      <input type="submit" value="Search" class="btn btn-success btn-md">
                    </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0">Bank Transaction Report</h4></center>
              <div class="table-responsive">
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">
                  <thead> 
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.bank') }} {{ __('messages.name') }}</td>
                      <!--<td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">:</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->bank_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.account_name') }}</td>
                      <!--<td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">:</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->account_name}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.account_no') }}</td>
                      <!--<td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">:</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->account_no}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.account_type') }}</td>
                      <!--<td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">:</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->bankaccount_accounttype_object->name}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.branch') }}</td>
                      <!--<td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">:</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$singledata->bank_branch}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.created_date') }}</td>
                      <!--<td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">:</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><?php echo dateFormateForView($singledata->opening_date); ?></td>
                    </tr>
                  </thead>
                </table>
              </div>
              
              <div class="table-responsive">
                @if(!empty($start_date) && !empty($end_date))
                <center><h4 style="margin: 0">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
                @else
                  <center><h4 style="margin: 0">Date : {{date('d-m-Y')}}</h4></center>
                @endif
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">
                  <thead> 
                    <tr style="background: #ccc;">  
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.date') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.reason') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.note') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.credit') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.debit') }}</th>
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

                      $sum = 0;
                      $debit = 0;
                      $credit = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php $rowCount++; ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php echo dateFormateForView($data->transaction_date); ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->note)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          $reasons = $data->reason;

                          if(preg_match("/Opening Balance/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }elseif (preg_match("/deposit/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }elseif (preg_match("/receive/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          if(preg_match("/withdraw/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }elseif (preg_match("/transfer/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }elseif (preg_match("/payment/", $reasons)) {
                            echo number_format($data->amount, 2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        {{number_format($sum, 2)}}
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                    <tr>
                      <td colspan="7" align="center">
                        <h4 style="color: #ccc">No Data Found . . .</h4>
                      </td>
                    </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="4" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} <?php echo number_format($credit, 2);?></b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} <?php echo number_format($debit, 2);?></b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} <?php echo number_format($sum, 2);?></b></td>
                    </tr>
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

    $logo = '../public/storage/app/public/uploads/logo/'.$siteInfo->image;

    $header = '<td width="20%"><img src="'.$logo.'" width="70px" height="70px"></td><td width="80%"><center><h3 style="margin:0; padding:0; margin-bottom: 0px">'.$siteInfo->company_name.'</h3>'.$siteInfo->address.'<br> Mobile : '.$siteInfo->phone.', Email : '.$siteInfo->email.'</center></td>';
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
    //mywindow.document.write('<center><u><span style="font-weight: bold; font-size: 15px">Other Receive Report</span></u><center>');    
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