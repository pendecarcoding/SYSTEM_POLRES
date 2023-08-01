@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
$level = Level::all();

 ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Surat Keluar</h1>
      <p>Menu untuk membuat Surat Keluar</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard </a></li>
    </ul>
  </div>

<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Preview {{$jenis->nama_jenis_surat}}
        <a href="{{url('surat_keluar')}}" style="color:white;"class="btn waves-effect waves-light btn-danger pull-right">Kembali</a>
      </h4>
<br>
    <iframe src="https://docs.google.com/gview?url={{url('print_ready/'.$surat->file_surat)}}&embedded=true" style="width:100%;border:1px solid #ccc;height:90vh;"></iframe>

</div>
</div>
</div>
</div>



</main>
@endsection
