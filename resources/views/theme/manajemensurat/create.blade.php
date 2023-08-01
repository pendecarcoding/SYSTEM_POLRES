@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
$level = Level::all();
 ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Template Surat</h1>
      <p>Menu untuk mengatur template surat</p>
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
      <h4 class="card-title">Tambah Jenis Surat
        <a href="{{url('template_surat')}}" style="color:white;"class="btn waves-effect waves-light btn-danger pull-right">Kembali</a>
      </h4>

      <form class="" action="{{URL::full()}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="">Nama Jenis</label>
          <input required type="text" class="form-control" name="nama_jenis_surat" value="{{$edit->nama_jenis_surat ?? null}}">
        </div>
        <div class="form-group">
          <label for="">Template</label>
          <input accept="application/msword"  type="file" class="form-control" name="template" value="">
          @if(!empty($edit) && $edit->template != null && file_exists(public_path('template_surat/'.$edit->template)))<small class="text-warning">Pilih berkas jika ingin diganti</small><br><a href="{{url('template_surat/'.$edit->template)}}" class="btn btn-sm btn-info">{{$edit->template}}</a>  @endif
        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-md pull-right" name="save" value="{{$edit->id ?? 'add'}}">Tambahkan</button>
        </div>

      </form>
    </div>
  </div>
</div>
</div>



</main>
@endsection
