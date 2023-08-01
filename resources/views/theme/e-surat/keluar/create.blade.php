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
      <h4 class="card-title">Formulir {{$jenis->nama_jenis_surat}}
        <a href="{{url('surat_keluar')}}" style="color:white;"class="btn waves-effect waves-light btn-danger pull-right">Kembali</a>
      </h4>
      <!-- Modal -->
      <br><br>
      @if ($errors->any())
<div class="alert alert-danger">
<ul>
  @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
  @endforeach
</ul>
</div>
@endif
      <form class="" action="{{url()->full()}}" method="post">
        @csrf
        @foreach($field as $row)
        <?php $f = $row->field;?>
        <div class="form-group">
          <small>{{$row->desc}}</small>
          @if($row->field_type=='textarea')
          <textarea name="{{$row->field}}" class="form-control">{{$edit->$f ?? null}}</textarea>
          @elseif($row->field_type=='text' || $row->field_type=='date')
          <input type="{{$row->field_type}}" class="form-control" name="{{$row->field}}" value="{{$edit->$f ?? null}}">
          @elseif($row->field_type=='pegawai')
          <?php
          function datapegawai(){
            return json_decode(file_get_contents("https://absensi.bengkaliskab.go.id/API/RASENGAN/datapegawai?kode_unitkerja=".session()->get('kode_unitkerja')));
          }
          ?>
          <select  class="form-control datapegawai select2" name="{{$row->field}}[]" multiple="" id="exampleSelect2" style="width: 100%;color:white;">
            @foreach(datapegawai() as $row)
            <option value="{{$row->no}}">{{$row->nama}} [{{$row->nip_baru}}]</option>
            @endforeach
          </select>

          @else
          @endif
        </div>
        @endforeach
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-md pull-right" name="buat_surat" value="{{empty($edit) ? 'add' : 'edit'}}">{{empty($edit) ? 'Buat' : 'Edit'}} Surat</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>



</main>
@endsection
