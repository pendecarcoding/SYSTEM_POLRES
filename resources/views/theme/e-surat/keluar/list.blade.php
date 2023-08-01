@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
$level = Level::all();
function jns($id){
  $d = DB::table('jenis_surat')->where('id',$id)->first();
  return $d->nama_jenis_surat;
}
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
  @include('theme.Layouts.alert')

<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Daftar Surat Keluar
        <a data-toggle='modal' href="#tambah" data-target="#tambah" style="color:white;"class="btn waves-effect waves-light btn-primary pull-right">Tambah Surat</a>
      </h4>
      <!-- Modal -->
      <br><br>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
        <tr>
          <th>#</th>
          <th>Jenis Surat</th>
          <th>Tujuan</th>
          <th>Tgl Surat</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          @foreach($index as $k=> $row)
          <tr>
            <td>{{$k+1}}</td>
            <td>{{jns($row->jenis_surat)}}</td>
            <td></td>
            <td>0</td>
            <td>{{$row->status_surat}}</td>
            <td><a href="{{url('surat_keluar/preview/'.base64_encode($row->id_surat))}}"><i class="fa fa-eye" aria-hidden></i> </a> &nbsp;&nbsp<a href="{{url('surat_keluar/edit/'.base64_encode($row->id_surat))}}"><i class="fa fa-edit text-warning" aria-hidden></i> </a> &nbsp;&nbsp<a onclick="return confirm('Yakin untuk menghapus?')" href="{{url('surat_keluar?delete='.base64_encode($row->id_surat))}}"><i class="fa fa-trash text-danger" aria-hidden></i> </a></td>

          </tr>
          @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>



</main>
<div class="modal fade" id="tambah" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih Jenis Surat</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
      <ul class="list-group">
        @foreach(DB::table('jenis_surat')->wherein('kode_unitkerja',['ALL',session()->get('kode_unitkerja')])->get() as $row)
        <a class="list-group-item" href="{{url('surat_keluar/create/'.base64_encode($row->id))}}"> &bullet; {{$row->nama_jenis_surat}}</a>
        @endforeach
      </ul>
      </div>
    </div>
  </div>
      </div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
