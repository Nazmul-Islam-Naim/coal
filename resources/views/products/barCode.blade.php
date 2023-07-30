@extends('layouts.layout')
@section('title', 'Barcode')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('messages.bar_code') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Barcode</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  @include('common.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-file"></i> {{ __('messages.bar_code') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <form id="addNumber" method="get">
                <div class="form-group">
                  <label>{{ __('messages.no_of_barcode') }}</label>
                  <input type="text" name="barcode_number" required="">
                  <input type="submit" value="Get Barcode">
                </div>
              </form>
            </div>
            <div id="mydiv">
            <div class="col-md-12">
              <div class="col-md-3" style="padding: 7px">
              <?php
                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                echo '<figure><img src="data:image/png;base64,' . base64_encode($generator->getBarcode($id, $generator::TYPE_CODE_128)) . '"><figcaption>'.$id.'</figcaption></figure>';
              ?>
              </div>
              
              <?php
                if (!empty($_GET['barcode_number'])) {
                  for ($x = 0; $x < $_GET['barcode_number'] - 1; $x++) {
                    //echo $x.'<br>';
                    echo "<div class='col-md-3' style='padding: 7px'>";
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    echo '<figure><img src="data:image/png;base64,' . base64_encode($generator->getBarcode($id, $generator::TYPE_CODE_128)) . '"><figcaption>'.$id.'</figcaption></figure>';
                    echo "</div>";
                  }
                }
              ?>
            </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer">
          <input type="button" value="Print" onclick="PrintElem('#mydiv')" class="btn btn-success btn-sm"/>
        </div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<script type="text/javascript">
    function PrintElem(elem){
      Popup($(elem).html());
    }
    function Popup(data){
      var mywindow = window.open('', 'my div', 'height=1000,width=1000');
      var is_chrome = Boolean(mywindow.chrome);
      mywindow.document.write(data);

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