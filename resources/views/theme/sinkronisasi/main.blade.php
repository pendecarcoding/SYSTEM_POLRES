@extends('theme.Layouts.design')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-sync"></i> Sinkronisasi Data</h1>
      <p>Menu untuk sinkron data pegawai di Unit kerja anda</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard </a></li>
    </ul>
  </div>

<div class="row">
<div class="col-12">
  <?php
dd(Fungsi::get_pegawai_no('2993')->nama);
   ?>
<center>  <a href="{{url('sinkronisasi_data?act=true')}}" style="color:white;"class="btn waves-effect waves-light btn-primary" onclick="return confirm('Sinkronisasi Sekarang?')">Sinkronisasi Sekarang</a></center>
</div>
</div>



</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
