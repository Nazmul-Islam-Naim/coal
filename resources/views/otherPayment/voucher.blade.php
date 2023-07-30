@extends('layouts.layout')
@section('title', 'Add Other Payment Voucher')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.add_payment_voucher') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.report') }}</li>
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
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> {{ __('messages.add_payment_voucher') }}</h3>
          <div class="form-inline pull-right">
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/daily-transaction'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list"></i> <b>{{ __('messages.daily_transaction') }}</b></a>         
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-bank"></i> <b>{{ __('messages.accounts') }}</b></a>         
            </div>
            <div class="input-group">
              <a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> <b>{{ __('messages.receive_voucher') }}</b></a>         
            </div>
            <div class="input-group">          
              <a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher-report'}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-list-alt"></i> <b>{{ __('messages.payment_voucher') }}</b></a>          
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(array('route' =>['payment-voucher.store'],'method'=>'POST')) !!}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.type') }}</label>
                <select class="form-control Type select2" name="payment_type_id" required=""> 
                  <option value="">--Select--</option>
                  @foreach($alltype as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.sub_type') }}</label>
                <select class="form-control SubType" name="payment_sub_type_id" required="">
                </select>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.amount') }}</label>
                <input type="number" name="amount" class="form-control" value="" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.payment_for') }}</label>
                <input type="text" name="payment_for" class="form-control" value="" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group"> 
                <label>{{ __('messages.date') }}</label>
                <input type="text" name="payment_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" required>
              </div>
              <div class="form-group"> 
                <label>{{ __('messages.payment_method') }}</label>
                <select class="form-control select2" name="bank_id">
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
          <!-- /.row -->
          {!! Form::close() !!}
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
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
          //url: "{{URL::to('find-payment-subtype-with-type-id')}}",
          url: "{{$baseUrl.'/'.config('app.op').'/find-payment-subtype-with-type-id'}}",
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