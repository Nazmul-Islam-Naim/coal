<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title')</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap 3.3.7 -->
{!!Html::style('custom/css/bootstrap.min.css')!!}
<!-- Font Awesome -->
{!!Html::style('custom/css_icon/font-awesome/css/font-awesome.min.css')!!}
<!-- Ionicons -->
{!!Html::style('custom/css_icon/Ionicons/css/ionicons.min.css')!!}
<!-- Theme style -->
{!!Html::style('custom/css/AdminLTE.css')!!}
{!!Html::style('custom/css/skins/_all-skins.css')!!}
{!!Html::style('custom/css/bootstrap-tagsinput.css')!!}
{!!Html::style('custom/css/style.css')!!}

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- jQuery 3 -->
{!!Html::script('custom/js/plugins/jquery/dist/jquery.min.js')!!}
<!-- Bootstrap 3.3.7 -->
{!!Html::script('custom/js/plugins/bootstrap/dist/js/bootstrap.min.js')!!}
{!!Html::script('custom/js/plugins/bootstrap/dist/js/bootstrap-confirmation.min.js')!!}
<!-- SlimScroll -->
{!!Html::script('custom/js/plugins/jquery-slimscroll/jquery.slimscroll.js')!!}
<!-- FastClick -->
{!!Html::script('custom/js/plugins/fastclick/lib/fastclick.js')!!}
<!-- AdminLTE App -->
{!!Html::script('custom/js/adminlte.js')!!}
<!--datepicker-->
{!!Html::script('custom/js/plugins/datepicker/bootstrap-datepicker.js')!!}
{!!Html::style('custom/js/plugins/datepicker/datepicker3.css')!!}
{!!Html::script('custom/js/bootstrap-tagsinput.js')!!}
{!!Html::script('custom/js/demo.js')!!}
{!!Html::script('custom/js/plugins/chart/chart.js')!!}
{!!Html::style('custom/js/plugins/select/select2.min.css')!!}
{!!Html::script('custom/js/plugins/select/select2.min.js')!!}
{!!Html::script('custom/js/notify.js')!!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.0.1/ckeditor.js"></script>
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.slimScrollBar{
    position: absolute;
    top: 0px;
    opacity: 0.4;
    display: none;
    border-radius: 7px;
    z-index: 99;
    right: 1px;
    height: 115.457px;
    width: 15px !important;
    background: red !important;
} 
.select2-container .select2-selection {
  height: 34px !important; 
  width: 100% !important;
}
.select2-container--default.select2-container{
  width: 100% !important;  
}
</style>
</head>
<body class="hold-transition skin-red sidebar-mini fixed">
<?php 
  $url = Request::path(); 
  $loginImg = "custom/img/photo.png";
?>
<!-- Site wrapper -->
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="{{URL::To('/')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><i class="fa fa-dashboard fa-2x" aria-hidden="true"></i></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b style="font-size: 15px;"> COAL MANAGEMENT</b></span> </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown notifications-menu">
            <!--a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" title="Select Language"></a>-->
            <a href="javascript:void(0)" title="Select Language">
              <!--i class="fa fa-language"></i>
              <span class="label label-warning">10</span> -->
              <select class="form-control changeLang" style="padding: 0px;margin: 0px;height: 21px;border: 0px solid #dd4b39;">
                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                <option value="bn" {{ session()->get('locale') == 'bn' ? 'selected' : '' }}>Bangla</option>
              </select>
            </a>
          </li>

          <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!!Html::image( asset($loginImg), 'User Image', array('class' => 'user-image'))!!}<span class="hidden-xs">{{Auth::user()->name}}</span> </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">{!!Html::image( asset($loginImg), 'User Image', array('class' => 'img-circle'))!!}
                <p>{{Auth::user()->name}}<br/>
                  <small></small>
                  <small></small></p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left"> <a href="#" data-toggle="modal" data-target="#profile_modal" class="btn btn-primary btn-flat"><i class="fa fa-user-circle"></i> Profile</a> </div>
                <div class="pull-right"> 
                  <a id="__logout_system" href="{{ route('logout') }}" class="btn btn-danger btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Sign Out
                  </a> 
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- =============================================== -->
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image"> {!!Html::image(asset($loginImg), 'User Image', array('class' => 'img-circle', 'style'=>'max-height: 45px'))!!}</div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
      </div>
      <?php
        $baseUrl = URL::to('/');
        $currency = DB::table('currency')->where('status', '1')->first();
        Session::put('currency', 'BDT');
      ?>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="{{($url=='dashboard') ? 'active':''}}"> <a href="{{URL::To('dashboard')}}"> <i class="fa fa-dashboard"></i> <span>{{ __('messages.dashboard') }}</span> </a> </li>

        <li class="treeview {{($url==config('app.account').'/account-type' || $url==config('app.account').'/bank-account' || $url==config('app.account').'/cheque-book' || $url==config('app.account').'/cheque-no' || $url==config('app.account').'/daily-transaction' || $url==config('app.account').'/final-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-usd"></i> <span>{{ __('messages.menu_accounts') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.account').'/account-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.account').'/account-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.account_type') }}</a></li>
            <li class="{{($url==config('app.account').'/bank-account')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bank_account') }}</a></li>
            <li class="{{($url==config('app.account').'/cheque-book')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.account').'/cheque-book'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.cheque_book') }}</a></li>
            <li class="{{($url==config('app.account').'/cheque-no')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.account').'/cheque-no'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.cheque_no') }}</a></li>
            <li class="{{($url==config('app.account').'/daily-transaction')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.account').'/daily-transaction'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.daily_transaction') }}</a></li>
            <!--<li class="{{($url==config('app.account').'/final-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.account').'/final-report'}}"><i class="fa fa-angle-double-right"></i>Final Report</a></li>-->
          </ul>
        </li>
        
        <li class="treeview {{($url==config('app.op').'/payment-type' || $url==config('app.op').'/payment-voucher' || $url==config('app.op').'/payment-sub-type' || $url==config('app.op').'/payment-voucher-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-credit-card"></i> <span>{{ __('messages.menu_opayment') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.op').'/payment-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.payment_type') }}</a></li>
            <li class="{{($url==config('app.op').'/payment-sub-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-sub-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_payment_sub_type') }}</a></li>
            <li class="{{($url==config('app.op').'/payment-voucher')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.payment_voucher') }}</a></li>
            <li class="{{($url==config('app.op').'/payment-voucher-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.payment_voucher_report') }}</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.or').'/receive-type' || $url==config('app.or').'/receive-voucher' || $url==config('app.or').'/receive-sub-type' || $url==config('app.or').'/receive-voucher-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-credit-card"></i> <span>{{ __('messages.menu_oreceive') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.or').'/receive-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.or').'/receive-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_receive_type') }}</a></li>
            <li class="{{($url==config('app.or').'/receive-sub-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.or').'/receive-sub-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_receive_sub_type') }}</a></li>
            <li class="{{($url==config('app.or').'/receive-voucher')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.receive_voucher') }}</a></li>
            <li class="{{($url==config('app.or').'/receive-voucher-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.or').'/receive-voucher-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.receive_voucher_report') }}</a></li>
          </ul>
        </li>
        
          {{-- branch manager --}}
        <li class="treeview {{($url==config('app.bm').'/branches' || $url==config('app.bm').'/report-by-mother-vasel' || $url==config('app.bm').'/cheque-no' || $url==config('app.bm').'/daily-transaction' || $url==config('app.bm').'/final-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-usd"></i> <span>{{ __('messages.branch_mm') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.bm').'/branches')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.bm').'/branches'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.branch') }}</a></li>
            <!--<li class="{{($url==config('app.bm').'/report-by-mother-vasel')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.bm').'/report-by-mother-vasel'}}"><i class="fa fa-angle-double-right"></i>Mother Vasel</a></li>-->
          </ul>
        </li>
          {{-- stock management --}}
        <li class="treeview {{($url==config('app.sm').'/branch-stock' || $url==config('app.sm').'/stock-product' || $url==config('app.sm').'/add-to-stock' || $url==config('app.sm').'/distribute-to-branch' || $url==config('app.sm').'/distribution-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-usd"></i> <span>{{ __('messages.stock_mm') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.sm').'/add-to-stock')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sm').'/add-to-stock'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.add_to_stock') }}</a></li>
            <li class="{{($url==config('app.sm').'/branch-stock')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sm').'/branch-stock'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.branch_stock') }}</a></li>
            <li class="{{($url==config('app.sm').'/stock-product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sm').'/stock-product'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.main_stock') }}</a></li>
            <li class="{{($url==config('app.sm').'/distribute-to-branch')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sm').'/distribute-to-branch'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.distribute_to_branch') }}</a></li>
            <li class="{{($url==config('app.sm').'/distribution-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sm').'/distribution-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.distribute_report') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{($url==config('app.product').'/product-type' || $url==config('app.product').'/product' || $url==config('app.product').'/product-brand' || $url==config('app.product').'/stock-product' || $url==config('app.product').'/date-wise-stock-product' || $url==config('app.product').'/product-sub-type' || $url==config('app.product').'/product-unit' || $url==config('app.product').'/update-stock-product' ||  $url==config('app.product').'/buy-product-by-lc' || $url==(request()->is(config('app.product').'/add-lc-product/*')) || $url==(request()->is(config('app.product').'/lc-single-detail/*')) || $url==config('app.product').'/single-lc-wise-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-product-hunt"></i> <span>{{ __('messages.product') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.product').'/product-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_type') }}</a></li>
            <!--<li class="{{($url==config('app.product').'/product-sub-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-sub-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_sub_type') }}</a></li>-->
            <!--<li class="{{($url==config('app.product').'/product-brand')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-brand'}}"><i class="fa fa-angle-double-right"></i>Product Unit</a></li>-->
            <li class="{{($url==config('app.product').'/product-unit')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-unit'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_unit') }}</a></li>
            <li class="{{($url==config('app.product').'/product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product') }}</a></li>
            <!--<li class="{{($url==config('app.product').'/stock-product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/stock-product'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.stock_product') }}</a></li>-->
            
            <!--<li class="{{($url==config('app.product').'/date-wise-stock-product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/date-wise-stock-product'}}"><i class="fa fa-angle-double-right"></i>Date Wise Stock Product</a></li-->
            <li class="{{($url==config('app.product').'/buy-product-by-lc' || $url==(request()->is(config('app.product').'/add-lc-product/*')) || $url==(request()->is(config('app.product').'/lc-single-detail/*')))?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/buy-product-by-lc'}}"><i class="fa fa-angle-double-right"></i>Buy Product by LC</a></li>
            <!--<li class="{{($url==config('app.product').'/single-lc-wise-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/single-lc-wise-report'}}"><i class="fa fa-angle-double-right"></i>Single LC Wise Report</a></li>-->
            <!--<li class="{{($url==config('app.product').'/update-stock-product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/update-stock-product'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.stock_product_update') }}</a></li>-->
          </ul>
        </li>
        
        <li class="treeview {{($url==config('app.importer').'/importer-area' || $url==config('app.importer').'/product-importer' || $url==config('app.importer').'/product-importer-payment' || $url==config('app.importer').'/product-importer-payment-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.importer_mm') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.importer').'/product-importer')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.importer').'/product-importer'}}"><i class="fa fa-angle-double-right"></i><span>{{ __('messages.importer_info') }}</a></li>
            <!--<li class="{{($url==config('app.importer').'/product-importer-payment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.importer').'/product-importer-payment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.supplier_payment') }}</a></li>
            <li class="{{($url==config('app.importer').'/product-importer-payment-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.importer').'/product-importer-payment-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.supplier_payment_report') }}</a></li>-->
          </ul>
        </li>

        <li class="treeview {{($url==config('app.supplier').'/supplier-area' || $url==config('app.supplier').'/product-supplier' || $url==config('app.supplier').'/product-supplier-payment' || $url==config('app.supplier').'/product-supplier-payment-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.exporter_mm') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.supplier').'/product-supplier')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.exporter_info') }}</a></li>
            <li class="{{($url==config('app.supplier').'/product-supplier-payment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier-payment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.exporter_payment') }}</a></li>
            <li class="{{($url==config('app.supplier').'/product-supplier-payment-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier-payment-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.exporter_payment_report') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{($url==config('app.supplier').'/rs-users') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.supplier_mm') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.supplier').'/rs-users')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/rs-users'}}"><i class="fa fa-angle-double-right"></i><span>{{ __('messages.rs_user') }}</a></li>
          </ul>
        </li>

        <!--<li class="treeview {{($url==config('app.ei').'/exporter-info' || $url==config('app.ei').'/importer-info' ) ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>IMPORTER</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.ei').'/exporter-info')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.ei').'/exporter-info'}}"><i class="fa fa-angle-double-right"></i>Exporter</a></li>
            <li class="{{($url==config('app.ei').'/importer-info')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.ei').'/importer-info'}}"><i class="fa fa-angle-double-right"></i>Importer</a></li>
          </ul>
        </li>-->

        @if(Auth::user()->type==1)
        <li class="treeview {{($url==config('app.purchase').'/lc' || 
        $url==config('app.purchase').'/lc-report' ||  
        $url==config('app.purchase').'/lc/create' || 
        $url==config('app.purchase').'/lc-payment-report' || 
        $url==config('app.purchase').'/lc-fees' || 
        $url==config('app.purchase').'/fee-type' || 
        $url==config('app.purchase').'/lc-fees-update-report' || 
        $url==config('app.purchase').'/lc-payment' || 
        $url==config('app.purchase').'/lc-expire' || 
        $url==config('app.purchase').'/lc-product-status' ||
        $url==config('app.purchase').'/lc-fee-payments-report') ? 'active':''}}"> 
        <a href="#"> <i class="fa fa-exchange">
          </i> <span>{{ __('messages.purchase_product') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> 
        </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.purchase').'/lc/create')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/lc/create'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.Create_LC') }}</a></li>
            <li class="{{($url==config('app.purchase').'/lc')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/lc'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.LC_list') }}</a></li>
            <li class="{{($url==config('app.purchase').'/lc-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/lc-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.LC_Report') }}</a></li>
            <li class="{{($url==config('app.purchase').'/lc-payment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/lc-payment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.LC_payment') }}</a></li>
            <li class="{{($url==config('app.purchase').'/fee-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/fee-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.fee_type') }}</a></li>
            <li class="{{($url==config('app.purchase').'/lc-fees')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/lc-fees'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.LC_fees_payment') }}</a></li>
            <li class="{{($url==config('app.purchase').'/lc-fee-payments-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/lc-fee-payments-report'}}"><i class="fa fa-angle-double-right"></i>LC Fees Payment Report</a></li>
            <li class="{{($url==config('app.purchase').'/lc-product-status')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/lc-product-status'}}">
              <i class="fa fa-angle-double-right"></i>Lc Product Status</a>
            </li>
          </ul>
        </li>
        @endif
        <li class="treeview {{($url==config('app.customer').'/customer' || $url==config('app.customer').'/achieve-gift-point' || $url==config('app.customer').'/customer-bill-collections' || $url==config('app.customer').'/customer-bill-collection-report' || $url==config('app.customer').'/daily-bill-collection-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.customer') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.customer').'/customer')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/customer'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.customer') }}</a></li>
            <li class="{{($url==config('app.customer').'/customer-bill-collections')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bill_collection') }}</a></li>
            
            <li class="{{($url==config('app.customer').'/customer-bill-collection-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collection-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bill_collection_report') }}</a></li>
            <!--<li class="{{($url==config('app.customer').'/daily-bill-collection-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/daily-bill-collection-report'}}"><i class="fa fa-angle-double-right"></i>Daily Bill Collection Report</a></li>-->
          </ul>
        </li>

        <!--Truck management -->
        <li class="treeview {{($url==config('app.truck').'/truck-info' || $url==config('app.truck').'/truck-rent-report' ) ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>TRUCK MANAGEMENT</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.truck').'/truck-info')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.truck').'/truck-info'}}"><i class="fa fa-angle-double-right"></i>Truck</a></li>
            <li class="{{($url==config('app.truck').'/truck-rent-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.truck').'/truck-rent-report'}}"><i class="fa fa-angle-double-right"></i>Rent Report</a></li>
          </ul>
        </li>
        <!--Lighter Agency management-->
        <li class="treeview {{($url==config('app.lighter').'/manage-agency' || $url==config('app.lighter').'/view-report' || $url==config('app.lighter').'/payment' ) ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.lighter_agency') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.lighter').'/manage-agency')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.lighter').'/manage-agency'}}"><i class="fa fa-angle-double-right"></i> {{ __('messages.manage_agency') }}</a></li>
            <li class="{{($url==config('app.lighter').'/view-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.lighter').'/view-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.Agency_Report') }}</a></li>
            <li class="{{($url==config('app.lighter').'/payment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.lighter').'/payment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.Agency_Payment') }}</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.sell').'/product-sell' || $url==config('app.sell').'/customer-list' || $url==(request()->is(config('app.sell').'/create-job-card/*')) || $url==config('app.sell').'/sell-report' || $url==config('app.sell').'/customer-for-save-quotation' || $url==config('app.sell').'/saved-quotation-list' || $url==(request()->is(config('app.sell').'/sell-saved-quotation-form/*/*')) || $url==(request()->is(config('app.sell').'/save-job-quotation-form/*')) || $url==config('app.sell').'/due-list' || $url==config('app.sell').'/advance-list' || $url==config('app.sell').'/bill-adjustment' || $url==config('app.sell').'/product-wise-sell-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-exchange"></i> <span>{{ __('messages.sell_product_mm') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            
            <li class="{{($url==config('app.sell').'/product-sell')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_product') }}</a></li>
            <li class="{{($url==config('app.sell').'/sell-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sell').'/sell-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_report') }}</a></li>
            <li class="{{($url==config('app.sell').'/product-wise-sell-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sell').'/product-wise-sell-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_wise_sell_report') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{($url==config('app.delivery').'/chalan/create' || $url==config('app.delivery').'/chalan') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>Delivery Chalan</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.delivery').'/chalan/create')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.delivery').'/chalan/create'}}"><i class="fa fa-angle-double-right"></i><span>Create Chalan</a></li>
            <li class="{{($url==config('app.delivery').'/chalan')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.delivery').'/chalan'}}"><i class="fa fa-angle-double-right"></i><span>View Chalan</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.employee').'/employees' || $url==config('app.employee').'/all-bill-list'  || $url==config('app.employee').'/employee-salary') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.employee_mm') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.employee').'/employees')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.employee').'/employees'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.employee_info') }}</a></li>
            <li class="{{($url==config('app.employee').'/all-bill-list')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.employee').'/all-bill-list'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.all_bill_list') }}</a></li>
            <li class="{{($url==config('app.employee').'/employee-salary')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.employee').'/employee-salary'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.salary_report') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{(
          $url==config('app.supplier').'/local-suppliers' || 
          $url==config('app.supplier').'/payable-suppliers' || 
          $url==config('app.supplier').'/payments-report' || 
          $url==config('app.supplier').'/payment-due-report' ||
          $url==config('app.purchase').'/local-purchases' ) ? 'active':''}}">
           <a href="#"> <i class="fa fa-user-o"></i> <span>Local Purchase</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.supplier').'/local-suppliers')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/local-suppliers'}}">
              <i class="fa fa-angle-double-right"></i>Local Suppliers</a>
            </li>
            <li class="{{($url==config('app.supplier').'/payable-suppliers')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/payable-suppliers'}}">
              <i class="fa fa-angle-double-right"></i>Payable Suppliers</a>
            </li>
            <li class="{{($url==config('app.supplier').'/payments-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/payments-report'}}">
              <i class="fa fa-angle-double-right"></i>Payments Report</a>
            </li>
            <li class="{{($url==config('app.supplier').'/payment-due-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/payment-due-report'}}">
              <i class="fa fa-angle-double-right"></i>Payment Due Report</a>
            </li>
            <li class="{{($url==config('app.purchase').'/local-purchases')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/local-purchases'}}">
              <i class="fa fa-angle-double-right"></i>Local Purhcase</a>
            </li>
          </ul>
        </li>
        @if(auth()->user()->type == 1)
        <li class="treeview {{(
          $url==config('app.user').'/user' || $url==config('app.user').'/user/create') ? 'active':''}}">
           <a href="#"> <i class="fa fa-user-o"></i> <span>User Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.user').'/user')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.user').'/user'}}">
              <i class="fa fa-angle-double-right"></i>Users</a>
            </li>
          </ul>
        </li>
        @endif

        <li>
           <a href="{{$baseUrl.'/'.config('app.user').'/changePassword'}}"> <i class="fa fa-lock"></i> <span>Change Password</a>
        </li>
        
        <!--<li class="treeview {{($url==config('app.return').'/return-form' || $url==config('app.return').'/return-list-from-customer' || $url==config('app.return').'/return-list-to-supplier' || $url==config('app.return').'/wastage-list') ? 'active':''}}"> <a href="#"> <i class="fa fa-retweet"></i> <span>{{ __('messages.product_return') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.return').'/return-form')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/return-form'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_return') }}</a></li>
            <!--<li class="{{($url==config('app.return').'/return-list-from-customer')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/return-list-from-customer'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_return_from_customer') }}</a></li>
            <li class="{{($url==config('app.return').'/return-list-to-supplier')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/return-list-to-supplier'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_return_to_supplier') }}</a></li>
            <li class="{{($url==config('app.return').'/wastage-list')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/wastage-list'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.wastage_product_return_report') }}</a></li>
          </ul>
        </li>-->
        
        @if(Auth::user()->type==1)
        <li class="treeview {{($url==config('app.amendment').'/other-receive-amenment' || 
        $url==config('app.amendment').'/other-payment-amenment' || 
        $url==config('app.amendment').'/purchase-product-edit' || 
        $url==config('app.amendment').'/branch-distribution-amendment' || 
        $url==config('app.amendment').'/sell-product-edit' || 
        $url==config('app.amendment').'/bank-deposit-amendment' || 
        $url==config('app.amendment').'/bank-withdraw-amendment' || 
        $url==config('app.amendment').'/bank-transfer-amendment' || 
        $url==config('app.amendment').'/supplier-payment-amendment' || 
        $url==config('app.amendment').'/customer-bill-amendment' || 
        $url==config('app.amendment').'/employee-salary-amendment' ||
        $url==config('app.amendment').'/local-purchase-list') ? 'active':''}}"> 
        <a href="#"> <i class="fa fa-edit"></i> <span>{{ __('messages.menu_amendment') }}</span> <span class="pull-right-container">
           <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.amendment').'/other-receive-amenment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/other-receive-amenment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_receive') }}</a></li>
            <li class="{{($url==config('app.amendment').'/other-payment-amenment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/other-payment-amenment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_payment') }}</a></li>

            <!--<li class="{{($url==config('app.amendment').'/purchase-product-edit')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/purchase-product-edit'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.purchase_product') }}</a></li>-->
            <li class="{{($url==config('app.amendment').'/sell-product-edit')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/sell-product-edit'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_product') }}</a></li>
            <li class="{{($url==config('app.amendment').'/bank-deposit-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/bank-deposit-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bank_deposit') }}</a></li>
            <li class="{{($url==config('app.amendment').'/bank-withdraw-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/bank-withdraw-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bank_withdraw') }}</a></li>
            <li class="{{($url==config('app.amendment').'/bank-transfer-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/bank-transfer-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bank_transfer') }}</a></li>

            <li class="{{($url==config('app.amendment').'/supplier-payment-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/supplier-payment-amendment'}}"><i class="fa fa-angle-double-right"></i>Supplier Payment</a></li>
            <li class="{{($url==config('app.amendment').'/customer-bill-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/customer-bill-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bill_collection') }}</a></li>
            <li class="{{($url==config('app.amendment').'/employee-salary-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/employee-salary-amendment'}}"><i class="fa fa-angle-double-right"></i>Employee Salary</a></li>
            <li class="{{($url==config('app.amendment').'/branch-distribution-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/branch-distribution-amendment'}}"><i class="fa fa-angle-double-right"></i>Branch Distribution</a></li>
            <li class="{{($url==config('app.amendment').'/local-purchase-list')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/local-purchase-list'}}">
              <i class="fa fa-angle-double-right"></i>Local Purchases</a>
            </li>
          </ul>
        </li>
        @endif

        <!--<li class="treeview {{($url==config('app.vat').'/vat-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-percent"></i> <span>{{ __('messages.menu_vat') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.vat').'/vat-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.vat').'/vat-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.vat_report') }}</a></li>
          </ul>
        </li>-->

        <!--li class="treeview {{($url=='bank-deposit-amenment') ? 'active':''}}"> <a href="#"> <i class="fa fa-th"></i> <span>Amenment</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url=='bank-deposit-amenment')?'active':''}}"><a href="{{URL::to('bank-deposit-amenment')}}"><i class="fa fa-angle-double-right"></i>Bank Deposit</a></li>
          </ul>
        </li-->
        <!--@if(Auth::user()->type==1)
        <li class="treeview {{($url==config('app.user').'/user') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.user') }} {{ __('messages.management') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.user').'/user')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.user').'/user'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.user') }}</a></li>
          </ul>
        </li>
        @endif-->

        <li class="{{($url==config('app.site-setting').'/site-setting') ? 'active':''}}"> <a href="{{$baseUrl.'/'.config('app.site-setting').'/site-setting'}}"> <i class="fa fa-cog"></i> <span>{{ __('messages.site_setting') }}</span> </a> </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> @yield('content') </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs"> <b>Designed & Developed by </b><a target="_blank" href="http://binaryit.com.bd/">Binary IT </a> && <a target="_blank" href="#">ThirtySeven IT</div>
    <strong>Copyright &copy; <?php echo date('Y');?> <a target="_blank" href="javascript:0">BinaryIT</a>.</strong> All rights
    reserved. 
  </footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

  <script type="text/javascript">

    $(document).ready(function(){
      $(".select2").select2({});
    });
  </script>

  <!-- data table -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

  <!-- Data Table Buttons -->
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
  <!-- ./Data Table Buttons -->

  <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

  <!--Data Table Button-->
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
  <!--./Data Table Button-->

  <script type="text/javascript">
    $(document).ready( function () {
      $('.myTable').DataTable({
        "pageLength": 100,
        initComplete: function() {
            $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
        }
      });
      

      $('.myScrollTable').DataTable({
        dom: 'Bfrtip',
        "pageLength": 10,
        "bLengthChange": false,
        //"scrollY": 200,
        "scrollY": 300,
        "scrollCollapse": true,
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        "paging":   false,
        //"ordering": false,
        "info":     false,
      });
    });
  </script>
  <!-- ./data table -->

  <!--Data Table Buttons-->
  <script type="text/javascript">
  $(document).ready(function() {
    $('.dataTableButton').DataTable( {
      dom: 'Bfrtip',
                            
      lengthMenu: [
        [100, 150, 200, -1 ],
        ['100 rows', '150 rows', '200 rows', 'Show all' ]
      ],
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
      ],
                            
      "pagingType": "full_numbers"
    });
  });
  </script>
  <!--./Data Table Buttons-->

  <!--Change Language-->
  <script type="text/javascript">
    var url = "{{ route('changeLang') }}";
  
    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });
  </script>
  <!--./Change Language-->
  <?php
    $siteSetting = DB::table('site_setting')->first();
  ?>
  <!--Print Report-->
  <script type="text/javascript">
    var Name = "<?php echo $siteSetting->company_name?>";
    var Phone = "<?php echo $siteSetting->phone?>";
    var Address = "<?php echo $siteSetting->address?>";
    var Email = "<?php echo $siteSetting->email?>";
    //var img = "{{asset('custom/img/logo.png')}}";
    var img = "{{asset('custom/img/report-header.png')}}";
    function printReport() {
     //$("#print_icon").hide();
     var reportTablePrint=document.getElementById("printTable");
     newWin= window.open("");
      /*newWin.document.write('<table width="100%"><tr><td><img src="'+img+'" height="100px" width="100%"></td></tr></table><br>');*/
      /*newWin.document.write('<center><h4 style="margin: 0px">'+Name+'<br>'+Phone+', '+Email+'<br>'+Address+'</h4></center><br>');*/
      //newWin.document.write('<table width="100%" style="border: 1px solid gray"><tr><td style="border-right: 1px solid gray"><center><img src="'+img+'" height="100%" width="100%"><center></td><td><center><h4 style="margin: 0px">'+Name+'<br>'+Phone+', '+Email+'<br>'+Address+'</h4></center></td></tr></table><br>');
      newWin.document.write('<table width="100%" style="border: 1px solid gray"><tr><td style="border-right: 1px solid gray"><center><img src="'+img+'" height="70px" width="100%"><center></td></tr></table><br>');
      //newWin.document.write('<table width="100%" style="border: 1px solid gray"><tr><td><center><h4 style="margin: 0px">'+Name+'<br>'+Phone+', '+Email+'<br>'+Address+'</h4></center></td></tr></table><br>');
      /*newWin.document.write('<html><head><title></title><style>a {text-decoration:none;}</style>');
      newWin.document.write('</head><body><table width="100%"><tr><td><img src="img/logo.png" height="100%" width="100%"></td><td><center><span style="font-size:28px;">Jalalabad Auto Care & Servicing Center<br>Kumar Para, Sylhet 3100</span><br><span style="font-size: 20px">Phone: (+880) 193777410/01881014009/0199002651</span> </td></tr></table><br>');*/
     newWin.document.write(reportTablePrint.innerHTML);
     newWin.print();
     newWin.close();
     $("#print_icon").show();
    }
  </script>
  <!--./Print Report-->
  
  <!--jquery datepicker-->
  <link href= "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>
  <script>
    $(function() {
      $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

      $(".monthpicker").datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "MM-yy",
          showButtonPanel: true,
          currentText: "This Month",
          onChangeMonthYear: function (year, month, inst) {
              $(this).val($.datepicker.formatDate('MM-yy', new Date(year, month - 1, 1)));
          },
          onClose: function(dateText, inst) {
              var month = $(".ui-datepicker-month :selected").val();
              var year = $(".ui-datepicker-year :selected").val();
              $(this).val($.datepicker.formatDate('MM-yy', new Date(year, month, 1)));
          }
      }).focus(function () {
          $(".ui-datepicker-calendar").hide();
      }).after(
          $("<a href='javascript: void(0);'>clear</a>").click(function() {
              $(this).prev().val('');
          })
      );
    });
    </script>
    <!--./jquery datepicker-->
    
    <!-- date time picker-->
   <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>-->
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">-->
    
    
    <script>
        $(function() {
            /*$('.datetimepicker').datetimepicker({
                format: 'DD-M-YYYY hh:mm A'
            });*/
            
            /*$('.datetimepicker').datetimepicker({
              format: 'DD-MM-YYYY hh:mm A',
            });*/
        });
    </script>
    <!-- date time picker-->

  {!!Html::script('custom/js/project.js')!!}
</body>
</html>
