@extends('layouts.layout')
@section('title', 'Product Distribution To Branch')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.distribute_to_branch') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('messages.home') }}</a></li>
    <li class="active">{{ __('messages.distribute') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border"></div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['distribute-to-branch.store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.branch') }} <strong style="color:red">*</strong></label>
                  <select name="branch_id" class="form-control select2" required="">
                      <option value="">--Select--</option>
                      @foreach($allbranch as $value)
                      <option value="{{$value->id}}">{{$value->name}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.lighter_agency') }} <strong style="color:red">*</strong></label>
                  <select name="lighter_agency_id" class="form-control select2" required="">
                      <option value="">--Select--</option>
                      @foreach($allagency as $value)
                      <option value="{{$value->id}}">{{$value->agency_name}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.lighter_name') }} <strong style="color:red">*</strong></label>
                  <input type="text" name="lighter_name" class="form-control" value="" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.product') }} <strong style="color:red">*</strong></label>
                  <select name="product_id" class="form-control select2" required="" id="Products">
                      <option value="">--Select--</option>
                      @foreach($allproduct as $value)
                      <option value="{{$value->id}}" data-stockqnty="{{$value->quantity}}">{{$value->name}} ({{$value->quantity}})</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.quantity') }} <strong style="color:red">*</strong></label>
                  <input type="text" name="quantity" class="form-control" value="" id="TotalQnty" onkeyup="calculateAmount(this.value,RentPerTon.value)" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.Rent') }} ({{ __('messages.per_ton') }}) <strong style="color:red">*</strong></label>
                  <input type="text" name="rent_per_ton" class="form-control" value="" id="RentPerTon" onkeyup="calculateAmount(this.value,TotalQnty.value)" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.Total_Rent') }} <strong style="color:red">*</strong></label>
                  <input type="text" name="total_rent" class="form-control" value="" id="TotalRentAmount" required="">
                </div>
              </div>
              
              </div>
              <div class="col-md-6">
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.Departure_Date_time') }} <strong style="color:red">*</strong></label>
                  <input type="datetime-local" name="departure_date" class="form-control" value="" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.arrival_Date_time') }} <strong style="color:red">*</strong></label>
                  <input type="datetime-local" name="arrival_date" class="form-control" value="" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.Loading_Date_time') }} <strong style="color:red">*</strong></label>
                  <input type="datetime-local" name="loading_date" class="form-control" value="" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.unLoading_Date_time') }} <strong style="color:red">*</strong></label>
                  <input type="datetime-local" name="unloading_date" class="form-control" value="" required="">
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="form-group"> 
                  <label>{{ __('messages.note') }}</label>
                  <textarea class="form-control" name="note" rows="9"></textarea>
                </div>
              </div>
              </div>
              
            </div>
          <!-- /.row -->
          </div>
        </div>
        <div class="box-footer">
            <div class="form-group"> 
              {{Form::submit('Distribute',array('class'=>'btn btn-success pull-right', 'style'=>'width:15%'))}}
            </div>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<script>
    function calculateAmount(x, y){
        var Z = parseFloat(x)*parseFloat(y);
        if(isNaN(Z)){
            $('#TotalRentAmount').val(0);
        }else{
            $('#TotalRentAmount').val(Z.toFixed(2));
        }
    }
    
    $(document).ready(function(){
      $("#TotalQnty").on('keyup', function(){
          var value = $(this).val();
          var stockQnty = $('select#Products').find(':selected').data('stockqnty');
          if(value>stockQnty){
              alert('Given Quantity Should be Small Than Stock !');
              $('#TotalQnty').val('');
          }
        
      });
    });
</script>
@endsection