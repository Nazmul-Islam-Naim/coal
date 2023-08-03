@extends('layouts.layout')
@section('title', 'Distribution Report Amendment')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>Distribution Report Amendment<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report</li>
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
          <h3 class="box-title"> <i class="fa fa-list-alt"></i>Distribution Report Amendment</h3>
          <div class="form-inline pull-right">
            {{-- <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus-circle"></i> <b>Payment Voucher</b></a>         
            </div> --}}
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
                        <form method="post" action="{{ route('branch-distribution-amendment.filter') }}">
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

            <div class="col-md-12" id="printTable">
              <center><h4 style="margin: 0px">Distribution Report Amendment</h4></center>
              @if(!empty($start_date) && !empty($end_date))
                <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;"> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{ __('messages.SL') }}</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Departure Date</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Arrival Date</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Branch</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Lighter Name</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Product Name</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total</th>
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

                      $sum = 0;
                      $ttlQnty = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $sum += $data->total_rent;
                        $ttlQnty += $data->quantity;
                      ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        {{$currentNumber++}}
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->departure_date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->arrival_date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->distribute_branch_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->distribute_agency_object->agency_name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->distribute_product_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->quantity}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->total_rent,2)}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">
                          {{Form::open(array('route'=>['delete-branch-distribution',$data->tok],'method'=>'DELETE'))}}
                            <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-sm confirm" title="Delete" style="width: 100%">Delete</button>
                          {!! Form::close() !!}
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="9" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
                {{-- <div class="col-md-12" align="right">{{$alldata->render()}}</div> --}}
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
  // dependancy dropdown using ajax
  $(document).ready(function() {
    $('.Type').on('change', function() {
      var typeID = $(this).val();
      if(typeID) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: "{{URL::to('find-payment-subtype-with-type-id')}}",
          data: {
            'id' : typeID
          },
          dataType: "json",

          success:function(data) {
            //console.log(data);
            if(data){
              $('.SubType').empty();
              $('.SubType').focus;
              $('.SubType').append('<option value="">Select</option>'); 
              $.each(data, function(key, value){
                console.log(data);
                $('select[name="payment_sub_type_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
              });
            }else{
              $('.SubType').empty();
            }
          }
        });
      }else{
        $('.SubType').empty();
      }
    });
  });
</script>
@endsection 