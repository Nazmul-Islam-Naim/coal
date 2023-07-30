<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title')</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap 3.3.7 -->
{!!Html::style('public/custom/css/bootstrap.min.css')!!}
<!-- Font Awesome -->
{!!Html::style('public/custom/css_icon/font-awesome/css/font-awesome.min.css')!!}
<!-- Ionicons -->
{!!Html::style('public/custom/css_icon/Ionicons/css/ionicons.min.css')!!}
<!-- Theme style -->
{!!Html::style('public/custom/css/AdminLTE.css')!!}
{!!Html::style('public/custom/css/skins/_all-skins.css')!!}
{!!Html::style('public/custom/css/bootstrap-tagsinput.css')!!}
{!!Html::style('public/custom/css/style.css')!!}

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- jQuery 3 -->
{!!Html::script('public/custom/js/plugins/jquery/dist/jquery.min.js')!!}
<!-- Bootstrap 3.3.7 -->
{!!Html::script('public/custom/js/plugins/bootstrap/dist/js/bootstrap.min.js')!!}
{!!Html::script('public/custom/js/plugins/bootstrap/dist/js/bootstrap-confirmation.min.js')!!}
<!-- SlimScroll -->
{!!Html::script('public/custom/js/plugins/jquery-slimscroll/jquery.slimscroll.js')!!}
<!-- FastClick -->
{!!Html::script('public/custom/js/plugins/fastclick/lib/fastclick.js')!!}
<!-- AdminLTE App -->
{!!Html::script('public/custom/js/adminlte.js')!!}
<!--datepicker-->
{!!Html::script('public/custom/js/plugins/datepicker/bootstrap-datepicker.js')!!}
{!!Html::style('public/custom/js/plugins/datepicker/datepicker3.css')!!}
{!!Html::script('public/custom/js/bootstrap-tagsinput.js')!!}
{!!Html::script('public/custom/js/demo.js')!!}
{!!Html::script('public/custom/js/plugins/chart/chart.js')!!}
{!!Html::style('public/custom/js/plugins/select/select2.min.css')!!}
{!!Html::script('public/custom/js/plugins/select/select2.min.js')!!}
{!!Html::script('public/custom/js/notify.js')!!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.0.1/ckeditor.js"></script>
</head>
<body class="hold-transition skin-red sidebar-mini fixed">
<?php 
  $url = Request::path(); 
  $loginImg = "public/custom/img/photo.png";
?>
<!-- Site wrapper -->
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="{{URL::To('/')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><i class="fa fa-dashboard fa-2x" aria-hidden="true"></i></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b style="font-size: 26px;"> {{ __('messages.dashboard') }}</b></span> </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown notifications-menu">
            <!--a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" title="Select Language"-->
            <a href="javascript:void(0)" title="Select Language">
              <!-- <i class="fa fa-language"></i> -->
              <!-- <span class="label label-warning">10</span> -->
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
            <li class="{{($url==config('app.account').'/final-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.account').'/final-report'}}"><i class="fa fa-angle-double-right"></i>Final Report</a></li>
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

        <li class="treeview {{($url==config('app.op').'/payment-type' || $url==config('app.op').'/payment-voucher' || $url==config('app.op').'/payment-sub-type' || $url==config('app.op').'/payment-voucher-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-credit-card"></i> <span>{{ __('messages.menu_opayment') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.op').'/payment-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.payment_type') }}</a></li>
            <li class="{{($url==config('app.op').'/payment-sub-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-sub-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_payment_sub_type') }}</a></li>
            <li class="{{($url==config('app.op').'/payment-voucher')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.payment_voucher') }}</a></li>
            <li class="{{($url==config('app.op').'/payment-voucher-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.op').'/payment-voucher-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.payment_voucher_report') }}</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.customer').'/customer' || $url==config('app.customer').'/achieve-gift-point' || $url==config('app.customer').'/customer-bill-collections' || $url==config('app.customer').'/customer-bill-collection-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.customer') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.customer').'/customer')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/customer'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.customer') }}</a></li>
            <li class="{{($url==config('app.customer').'/achieve-gift-point')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/achieve-gift-point'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.gift_point') }}</a></li>
            <li class="{{($url==config('app.customer').'/customer-bill-collections')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collections'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bill_collection') }}</a></li>
            <li class="{{($url==config('app.customer').'/customer-bill-collection-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.customer').'/customer-bill-collection-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bill_collection_report') }}</a></li>
          </ul>
        </li>
        
        <li class="treeview {{($url==config('app.employee').'/employees' || $url==config('app.employee').'/employee-salary') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>EMPLOYEE</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.employee').'/employees')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.employee').'/employees'}}"><i class="fa fa-angle-double-right"></i>Manage Employee</a></li>
            <li class="{{($url==config('app.employee').'/employee-salary')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.employee').'/employee-salary'}}"><i class="fa fa-angle-double-right"></i>Salary Report</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.product').'/product-type' || $url==config('app.product').'/product' || $url==config('app.product').'/product-brand' || $url==config('app.product').'/stock-product' || $url==config('app.product').'/product-sub-type' || $url==config('app.product').'/product-unit' || $url==config('app.product').'/update-stock-product') ? 'active':''}}"> <a href="#"> <i class="fa fa-product-hunt"></i> <span>{{ __('messages.product') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.product').'/product-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_type') }}</a></li>
            <li class="{{($url==config('app.product').'/product-sub-type')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-sub-type'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_sub_type') }}</a></li>
            <li class="{{($url==config('app.product').'/product-brand')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-brand'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_brand') }}</a></li>
            <li class="{{($url==config('app.product').'/product-unit')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product-unit'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_unit') }}</a></li>
            <li class="{{($url==config('app.product').'/product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/product'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product') }}</a></li>
            <li class="{{($url==config('app.product').'/stock-product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/stock-product'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.stock_product') }}</a></li>
            <!--<li class="{{($url==config('app.product').'/update-stock-product')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.product').'/update-stock-product'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.stock_product_update') }}</a></li>-->
          </ul>
        </li>

        <li class="treeview {{($url==config('app.supplier').'/supplier-area' || $url==config('app.supplier').'/product-supplier' || $url==config('app.supplier').'/product-supplier-payment' || $url==config('app.supplier').'/product-supplier-payment-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.supplier') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.supplier').'/supplier-area')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/supplier-area'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.area') }}</a></li>
            <li class="{{($url==config('app.supplier').'/product-supplier')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.supplier') }}</a></li>
            <li class="{{($url==config('app.supplier').'/product-supplier-payment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier-payment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.supplier_payment') }}</a></li>
            <li class="{{($url==config('app.supplier').'/product-supplier-payment-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier-payment-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.supplier_payment_report') }}</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.purchase').'/product-purchase' || $url==config('app.purchase').'/purchase-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-exchange"></i> <span>{{ __('messages.purchase_product') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.purchase').'/product-purchase')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/product-purchase'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.purchase_product') }}</a></li>
            <li class="{{($url==config('app.purchase').'/purchase-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.purchase').'/purchase-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.purchase_report') }}</a></li>
          </ul>
        </li>

        <li class="treeview {{($url=='food-type' || $url=='product-package' || $url==config('app.sell').'/product-sell' || $url==config('app.sell').'/pos-sell' || $url==config('app.sell').'/sell-report' || $url==config('app.sell').'/product-wise-sell-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-exchange"></i> <span>{{ __('messages.sell_product') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <!--li class="{{($url=='food-type')?'active':''}}"><a href="{{URL::to('food-type')}}"><i class="fa fa-angle-double-right"></i>Food Type</a></li>
            <li class="{{($url=='product-package')?'active':''}}"><a href="{{URL::to('product-package')}}"><i class="fa fa-angle-double-right"></i>Package</a></li-->
            <li class="{{($url==config('app.sell').'/product-sell')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sell').'/product-sell'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_product') }}</a></li>
            <!--<li class="{{($url==config('app.sell').'/pos-sell')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sell').'/pos-sell'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.pos_sell') }}</a></li>-->
            <li class="{{($url==config('app.sell').'/sell-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sell').'/sell-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_report') }}</a></li>
            <li class="{{($url==config('app.sell').'/product-wise-sell-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.sell').'/product-wise-sell-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_wise_sell_report') }}</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.vat').'/vat-report') ? 'active':''}}"> <a href="#"> <i class="fa fa-percent"></i> <span>{{ __('messages.menu_vat') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.vat').'/vat-report')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.vat').'/vat-report'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.vat_report') }}</a></li>
          </ul>
        </li>

        <li class="treeview {{($url==config('app.return').'/return-form' || $url==config('app.return').'/return-list-from-customer' || $url==config('app.return').'/return-list-to-supplier' || $url==config('app.return').'/wastage-list') ? 'active':''}}"> <a href="#"> <i class="fa fa-retweet"></i> <span>{{ __('messages.product_return') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.return').'/return-form')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/return-form'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.product_return') }}</a></li>
            <li class="{{($url==config('app.return').'/return-list-from-customer')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/return-list-from-customer'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_return_from_customer') }}</a></li>
            <li class="{{($url==config('app.return').'/return-list-to-supplier')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/return-list-to-supplier'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_return_to_supplier') }}</a></li>
            <li class="{{($url==config('app.return').'/wastage-list')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.return').'/wastage-list'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.wastage_product_return_report') }}</a></li>
          </ul>
        </li>
        @if(Auth::user()->type==1)
        <li class="treeview {{($url==config('app.amendment').'/other-receive-amenment' || $url==config('app.amendment').'/other-payment-amenment' || $url==config('app.amendment').'/purchase-product-edit' || $url==config('app.amendment').'/sell-product-edit' || $url==config('app.amendment').'/bank-deposit-amendment' || $url==config('app.amendment').'/bank-withdraw-amendment' || $url==config('app.amendment').'/bank-transfer-amendment' || $url==config('app.amendment').'/supplier-payment-amendment' || $url==config('app.amendment').'/customer-bill-amendment') ? 'active':''}}"> <a href="#"> <i class="fa fa-edit"></i> <span>{{ __('messages.menu_amendment') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.amendment').'/other-receive-amenment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/other-receive-amenment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_receive') }}</a></li>
            <li class="{{($url==config('app.amendment').'/other-payment-amenment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/other-payment-amenment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.other_payment') }}</a></li>

            <li class="{{($url==config('app.amendment').'/purchase-product-edit')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/purchase-product-edit'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.purchase_product') }}</a></li>
            <li class="{{($url==config('app.amendment').'/sell-product-edit')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/sell-product-edit'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.sell_product') }}</a></li>
            <li class="{{($url==config('app.amendment').'/bank-deposit-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/bank-deposit-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bank_deposit') }}</a></li>
            <li class="{{($url==config('app.amendment').'/bank-withdraw-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/bank-withdraw-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bank_withdraw') }}</a></li>
            <li class="{{($url==config('app.amendment').'/bank-transfer-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/bank-transfer-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bank_transfer') }}</a></li>

            <li class="{{($url==config('app.amendment').'/supplier-payment-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/supplier-payment-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.supplier_payment') }}</a></li>
            <li class="{{($url==config('app.amendment').'/customer-bill-amendment')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.amendment').'/customer-bill-amendment'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.bill_collection') }}</a></li>
          </ul>
        </li>
        @endif

        <!--li class="treeview {{($url=='bank-deposit-amenment') ? 'active':''}}"> <a href="#"> <i class="fa fa-th"></i> <span>Amenment</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url=='bank-deposit-amenment')?'active':''}}"><a href="{{URL::to('bank-deposit-amenment')}}"><i class="fa fa-angle-double-right"></i>Bank Deposit</a></li>
          </ul>
        </li-->
        @if(Auth::user()->type==1)
        <li class="treeview {{($url==config('app.user').'/user') ? 'active':''}}"> <a href="#"> <i class="fa fa-user-o"></i> <span>{{ __('messages.user') }} {{ __('messages.management') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li class="{{($url==config('app.user').'/user')?'active':''}}"><a href="{{$baseUrl.'/'.config('app.user').'/user'}}"><i class="fa fa-angle-double-right"></i>{{ __('messages.user') }}</a></li>
          </ul>
        </li>
        @endif

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
    <div class="pull-right hidden-xs"> <b>Designed & Developed by </b><a target="_blank" href="http://binary-it.net">Binary IT</a></div>
    <strong>Copyright &copy; <?php echo date('Y');?> <a target="_blank" href="javascript:0">BinaryIT</a>.</strong> All rights
    reserved. 
  </footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 450px; margin: 0 auto;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-circle"></i> Update Profile Information</h4>
      </div>
      <div class="modal-body">
        <h4 align="center" id="notifyMsg"></h4>
        {{Form::hidden('id',Auth::user()->id)}}
        <div class="form-group row">
          {{Form::label('name', 'Name:', array('class' => 'col-md-4 control-label'))}}
          <div class="col-md-8">
              <input type="text" class="form-control" id="name" value="{{  Auth::user()->name  }}" name="name" placeholder="Name">
          </div>
        </div>
        <div class="form-group row">
          {{Form::label('oldPassword', 'Old Password:', array('class' => 'col-md-4 control-label'))}}
          <div class="col-md-8">
              <input type="password" class="form-control" id="oldPassword" value="" name="exist_password" placeholder="Given old password">
              <input type="hidden" class="form-control" id="existPass" value="{{Auth::user()->password}}" name="old_password" placeholder="Enter old password">
          </div>
        </div>
        <div class="form-group row">
          {{Form::label('newPass', 'New Password:', array('class' => 'col-md-4 control-label'))}}
          <div class="col-md-8">
              <input type="password" class="form-control" id="newPass" value="" name="password" placeholder="Enter new password">
          </div>
        </div>
        <div class="form-group row">
          {{Form::label('confirmPass', 'Confirm Password:', array('class' => 'col-md-4 control-label'))}}
          <div class="col-md-8">
              <input type="password" class="form-control" id="confirmPass" value="" name="confirm_password" placeholder="Enter confirm password">
              <span id="confirmMsg"></span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnSave" value="add">Update</button>
      </div>
    </div>
  </div>
</div>

  <script type="text/javascript">
    $('#confirmPass').on('keyup', function () {
      if ($('#newPass').val() == $('#confirmPass').val()) {
        $('#confirmMsg').html('Password Matched !').css('color', 'green');
      } else 
        $('#confirmMsg').html('Password Do not Matched !').css('color', 'red');
    });

    $('#btnSave').on('click',function(){
        if ($('#newPass').val() == $('#confirmPass').val()){
          $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            method: "POST",
            url: "{{URL::to('update-profile')}}",
            data: {
              'id': $('input[name=id]').val(),
              'name': $('input[name=name]').val(),
              'exist_password': $('input[name=exist_password]').val(),
              'old_password': $('input[name=old_password]').val(),
              'password': $('input[name=password]').val(),
              'confirm_password': $('input[name=confirm_password]').val(),
            },
            dataType: "json",
            success: function(data){
              $('#notifyMsg').html(data[0]).css('color',data[1]);
              $('#notifyMsg').delay(500).fadeIn('normal', function() {
                $(this).delay(2000).fadeOut();
             });
            },
            error: function(data){
            }
          });
        }else{
          $('#confirmMsg').html('Password Do not Matched!!').css('color', 'red');
          return false;
        }
    });

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
    var img = "{{asset('public/custom/img/Baner.jpg')}}";
    //var img = "{{asset('public/custom/img/report-header.png')}}";
    function printReport() {
     //$("#print_icon").hide();
     var reportTablePrint=document.getElementById("printTable");
     newWin= window.open("");
     //newWin.document.write('<table width="100%"><tr><td><img src="'+img+'" height="100px" width="100%"></td></tr></table><br>');
      newWin.document.write('<center><h4 style="margin: 0px">'+Name+'<br>'+Phone+', '+Email+'<br>'+Address+'</h4></center><br>');
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

  {!!Html::script('public/custom/js/project.js')!!}
</body>
</html>
