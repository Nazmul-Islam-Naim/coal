<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title')</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
{!!Html::style('public/custom/css/bootstrap.min.css')!!}
<!-- Font Awesome -->
{!!Html::style('public/custom/css_icon/font-awesome/css/font-awesome.min.css')!!}
<!-- Ionicons -->
{!!Html::style('public/custom/css_icon/Ionicons/css/ionicons.min.css')!!}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
{!!Html::style('public/custom/css/login.css')!!}
<!-- jQuery 3 -->
{!!Html::script('public/custom/js/plugins/jquery/dist/jquery.min.js')!!}
<!-- Bootstrap 3.3.7 -->
{!!Html::script('public/custom/js/plugins/bootstrap/dist/js/bootstrap.min.js')!!}
</head>
<body>
<div class="container">
</div>
<div class="form">
  <div class="image_holder">
    <div style="margin-bottom:35px;font-size: 36px;"><i class="fa fa-key"></i> Login Panel</div>
  </div>
  @if(Session::get('error'))
  <div class="custom-alerts alert alert-danger fade in">
    <ul style="list-style-type:none">
      <li><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ Session::get('error') }}</li>
      <?php Session::put('error', NULL); ?>
    </ul>
  </div>
  @elseif ($errors->has('email'))
  <div class="custom-alerts alert alert-danger fade in"> <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $errors->first('email') }}</strong> </div>
  @endif
  <form name="form" action="{{ url('/login')}}"  class="login-form" method="POST" id="form">
    {{ csrf_field() }}
    <input id="email" type="text" name="email" value="developer@gmail.com" placeholder="Email" required style="border: 1px solid #337ab7;">
    <input id="password" type="password" name="password" placeholder="Password" value="123456" required style="border: 1px solid #337ab7;">
    <button type="submit" class="btn btn-primary"><i class="fa fa-user"></i> Log in</button>
  </form>
</div>
</body>
</html>
