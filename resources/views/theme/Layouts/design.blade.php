<?php
use App\AplikasiModel;
$apps = AplikasiModel::where('id_app','1')->first();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <script src="{{asset('theme/dist/sweet/dist/sweetalert-dev.js')}}"></script>
     <link rel="stylesheet" href="{{asset('theme/dist/sweet/dist/sweetalert.css')}}">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>{{$apps->app_name}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('vali/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('theme/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/select2/dist/css/select2.min.css')}}">

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">

@include('theme.Layouts.header')
@include('theme.Layouts.sidebar')

          @yield('content')
          @include('theme.Layouts.fotter')
