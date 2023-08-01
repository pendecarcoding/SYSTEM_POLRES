<?php
use App\AplikasiModel;
$apps = AplikasiModel::where('id_app','1')->first();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('vali/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Aplikasi Absensi</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>

    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Selamat Datang</h1>
      </div>
      <div class="login-box">
        <form class="login-form" action="{{url('loginpost')}}"> {{csrf_field()}}
        <center>
          <img src="{{url('logobks.png')}}" alt="Girl in a jacket" width="70" height="90" >
            @include('theme.Layouts.alert')
        </center>

          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control" type="text" name="uname" placeholder="Username" required autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" name="pass" placeholder="Password" required>
          </div>

          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>MASUK</button>
          </div>
        </form>

      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('vali/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('vali/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('vali/js/popper.min.js')}}"></script>
    <script src="{{asset('vali/js/main.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{asset('vali/js/plugins/pace.min.js')}}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>
