@extends('layouts.layout')
@section('title', 'Add Other Receive Voucher')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.add_receive_voucher') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.report') }}</li>
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
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.add_receive_voucher') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/daily-transaction'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list"></i> <b>{{ __('messages.daily_transaction') }}</b></a>         
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-bank"></i> <b>{{ __('messages.accounts') }}</b></a>         
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> <b>{{ __('messages.payment_voucher') }}</b></a>         
            </div>
            <div class="input-group">          
              <a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher-report'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> <b>{{ __('messages.receive_voucher_report') }}</b></a>          
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(array('route' =>['receive-voucher.store'],'method'=>'POST')) !!}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.receive') }} {{ __('messages.type') }}</label>
                <select class="form-control Type select2" name="receive_type_id" required=""> 
                  <option value="">--Select--</option>
                  @foreach($alltype as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.sub_type') }}</label>
                <select class="form-control SubType" name="receive_sub_type_id" required="">
                </select>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.amount') }}</label>
                <input type="number" name="amount" class="form-control" value="" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.receive_from') }}</label>
                <input type="text" name="receive_from" class="form-control" value="" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.date') }}</label>
                <input type="text" name="receive_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.receive_method') }}</label>
                <select class="form-control select2" name="bank_id" required="">
                  @foreach($allbank as $bank)
                  <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.issue_by') }}</label>
                <input type="text" name="issue_by" class="form-control" value="">
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.note') }}</label>
                <textarea name="note" rows="1" class="form-control"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              {{Form::submit('Save',array('class'=>'btn btn-success btn-md pull-right', 'style'=>'width:10%'))}}
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <!-- /.row -->
        <div class="box-footer"></div>
      </div>
    </div>
    <!-- /.box -->
  </div>
</section>
<!-- /.content -->

<?php
  $baseUrl = URL::to('/');
?>

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
          //url: "{{URL::to('find-receive-subtype-with-type-id')}}",
          url: "{{$baseUrl.'/'.config('app.or').'/find-receive-subtype-with-type-id'}}",
          data: {
            'id' : typeID
          },
          dataType: "json",

          success:function(data) {
            //console.log(data);
            if(data){
              $('.SubType').empty();
              $('.SubType').focus;
              $('.SubType').append('<option value="">--Select--</option>'); 
              $.each(data, function(key, value){
                console.log(data);
                $('select[name="receive_sub_type_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
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