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
      <h4 class="card-title">Daftar Jenis Surat
        <a href="{{url('template_surat/create')}}" style="color:white;"class="btn waves-effect waves-light btn-primary pull-right">Tambah Jenis Surat</a>
      </h4>
      <!-- Modal -->
      <br><br>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
        <tr>
          <th>#</th>
          <th>Jenis Surat</th>
          <th>Template</th>
          <th>Jumlah Data</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          <?php
          $db = DB::table('jenis_surat');
          if(session()->get('level') == 'adminsurat'):
            $q = $db->where('kode_unitkerja','ALL');
          else:
            $q = $db->where('kode_unitkerja',session()->get('kode_unitkerja'));
          endif;
          ?>
          @foreach($q->get() as $k=> $row)
          <tr>
            <td>{{$k+1}}</td>
            <td>{{$row->nama_jenis_surat}}</td>
            <td> @if($row->template != null && file_exists(public_path('template_surat/'.$row->template))) <a href="{{asset('template_surat/'.$row->template)}}" class="btb btn-sm btn-info">Lihat</a> @else NULL @endif</td>
            <td>0</td>
            <td>{{$row->status=='Y' ? 'Aktif':'Tidak Aktif'}}</td>
            <td><a href="{{url('template_surat/customize/'.base64_encode($row->id))}}"><i class="fa fa-cogs" aria-hidden></i> </a> &nbsp;&nbsp; <a href="{{url('template_surat/edit/'.base64_encode($row->id))}}"> <i class="fa fa-edit text-warning" aria-hidden></i> </a>   &nbsp;&nbsp;   <a onclick="return confirm('Yakin untuk menghapus?')" href="{{url('template_surat?delete='.base64_encode($row->id))}}"><i class="fa fa-trash text-danger" aria-hidden></i> </a></td>

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
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
