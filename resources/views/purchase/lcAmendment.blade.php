@extends('layouts.layout')
@section('title', 'LC Amendment')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1>LC Amendment<small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">LC Amendment</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-plus-circle"></i> LC Amendment</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('route' =>['branches.store'],'method'=>'POST')) !!}
        <div class="box-body">
          <div class="row">
              <div class="col-md-4 form-group"> 
                <label>LC No <span class="text-danger">*</span></label>
                <input type="text" name="lc_no" class="form-control" value="" autocomplete="off" required readonly>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Bank<span class="text-danger">*</span></label>
                <select name="bank_id" class="form-control" required id="bank">
                  <option value="">Select One</option>
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Importer<span class="text-danger">*</span></label>
                <select name="importer_id" class="form-control" required id="importer">
                  <option value="">Select One</option>
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Exporter<span class="text-danger">*</span></label>
                <select name="exporter_id" class="form-control" required>
                  <option value="">Select One</option>
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Origin Of Country<span class="text-danger">*</span></label>
                <input type="text" name="origin_of_country" class="form-control" value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Opening Date<span class="text-danger">*</span></label>
                <input type="text" name="opening_date " class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Expire Date<span class="text-danger">*</span></label>
                <input type="text" name="expire_date " class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Shipment Date<span class="text-danger">*</span></label>
                <input type="text" name="shipment_date " class="form-control datepicker" value="<?php echo date('Y-m-d');?>" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Product Type<span class="text-danger">*</span></label>
                <select name="produ_type_id" class="form-control" required>
                  <option value="">Select One</option>
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Product Name<span class="text-danger">*</span></label>
                <select name="product_name_id" class="form-control" required>
                  <option value="">Select One</option>
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Product Quantity<span class="text-danger">*</span></label>
                <input type="number" name="product_quantity " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Unit Price ($)<span class="text-danger">*</span></label>
                <input type="number" name="unit_price " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Total ($)<span class="text-danger">*</span></label>
                <input type="number" name="total " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Border<span class="text-danger">*</span></label>
                <select name="border_id" class="form-control" required>
                  <option value="">Select One</option>
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Dollar Rate (BDT)<span class="text-danger">*</span></label>
                <input type="number" name="dollar_rate " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Total (BDT)<span class="text-danger">*</span></label>
                <input type="number" name="total " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Margin (%)<span class="text-danger">*</span></label>
                <input type="number" name="margin " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Margin Amount (BDT)<span class="text-danger">*</span></label>
                <input type="number" name="margin_amount " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Bank Due<span class="text-danger">*</span></label>
                <input type="number" name="bank_due " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Commission (BDT)<span class="text-danger">*</span></label>
                <input type="number" name="commission " class="form-control " value="" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Insurance (BDT)<span class="text-danger">*</span></label>
                <input type="number" name="insurance " class="form-control " value="" autocomplete="off"  required>
              </div>
              {{-- <div class="col-md-12 form-group"> 
                <h3>Products Details</h3>
              </div>
              <div class="row" >
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Product Type <span class="text-danger">*</span></th>
                        <th scope="col">Product Name <span class="text-danger">*</span></th>
                        <th scope="col">Product Quantity <span class="text-danger">*</span></th>
                        <th scope="col">Uint Price ($) <span class="text-danger">*</span></th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody id="dynamic">
                      <tr>
                        <td class="col-md-3">
                          <select name="product_type_id" class="form-control"  required>
                            <option value="">Select One</option>
                          </select>
                        </td>
                        <td class="col-md-3">
                          <input type="text" name="product_name " class="form-control" value="" autocomplete="off"   required>
                        </td>
                        <td class="col-md-2">
                          <input type="number" name="product_quantity " class="form-control" value="" autocomplete="off"   required>
                        </td>
                        <td class="col-md-2">
                          <input type="number" name="unit_price " class="form-control" value="" autocomplete="off"   required>
                        </td>
                        <td class="col-md-2">
                          <button class=" form-control" id="addMore" title="Add More" style="background-color:green; color:aliceblue; width:35%"><i class="fa fa-plus"></i></button>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <td ></td>
                      <td ></td>
                      <td style="text-align: right"><label for="" style="margin-top:10px ">Total ($)</label></td>
                      <td ><input type="text" class="form-control"></td>
                    </tfoot>
                  </table>
                </div>
              </div> --}}
            </div>
          <!-- /.row -->
        </div>
        <div class="box-footer">
          <div class="form-group">
            {{Form::submit('Save',array('class'=>'btn btn-success', 'style'=>'width:15%; float:right'))}}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <!-- /.box -->
    </div>

  </div>
</section>
<!-- /.content -->
<script>
  $(document).ready(function () {
        var html = '<tr>';
            html += '<td class="col-md-3">';
            html += '<select name="product_type_id" class="form-control">';
            html += '<option value="">Select One</option>';
            html += '</select>';
            html += '</td>';
            html += '<td class="col-md-3">';
            html += '<input type="text" name="product_name " class="form-control" value="" autocomplete="off" required>';
            html += '</td>';
            html += '<td class="col-md-2">';
            html += ' <input type="number" name="product_quantity " class="form-control" value="" autocomplete="off" required>';
            html += '</td>';
            html += '<td class="col-md-2">';
            html += ' <input type="number" name="unit_price " class="form-control" value="" autocomplete="off" required>';
            html += '</td>';
            html += '<td class="col-md-2">';
            html += ' <button class=" form-control" id="cancle" title="Cancle" style="background-color:red; color:aliceblue; width:35%"><i class="fa fa-times"></i></button>';
            html += '</td>';
            html += '</tr>';
    $('#addMore').click(function(){
          $('#dynamic').append(html);

    });
    $(document).on('click','#cancle',function(){
      $(this).closest('tr').remove();

    });
  });
</script>
<script>
  $(document).ready(function () {
    $('#bank').css('pointer-events','none');
    $('#bank').css('background-color','#eee');
    $('#importer').css('pointer-events','none');
    $('#importer').css('background-color','#eee');
  });
</script>
@endsection 