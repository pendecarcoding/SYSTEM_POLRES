<?php
use App\Cmenu;
$class = new Cmenu();
?>
@extends('theme.Layouts.design')
@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-list"></i> Daftar Izin Dinas</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
  @include('theme.Layouts.alert')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a style="float:right;color:white" class="btn btn-primary">Tambah Data</a>
         <h4 class="card-title">Daftar Izin Dinas</h4>
         
        </div>
        <div class="card-body">
          <h6 class="card-subtitle"></h6>
          <br>
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pegawai</th>
                  <th>NO SPT</th>
                  <th>Mulai Dinas</th>
                  <th>Akhir Dinas</th>
                  <th>Tgl Pengajuan</th>
                  <th>Status</th>
                  <th>File</th>
                  <th width="10%"></th>
              </thead>
              <tbody>
                @foreach($data as $i =>$v)
                @php
                $pegawai =  $class->getpegawaifromiduser($v->id_pegawai);
                $diterima=  ($v->status=='Y')? 'Disetujui':'Di batalkan';
                $status  =  ($v->status=='A')? 'Menunggu Konfirmasi..':$diterima;
                $range   = explode('s/d',$v->rentang_absen);
                @endphp
                @if($pegawai != null)
                <tr>
                  <td>{{$i+1}}</td>
                  <td>{{$pegawai->nama}}</td>
                  <td>{{ $v->nospt }}</td>
                  <td>{{$range[0]}}</td>
                  <td>{{$range[1]}}</td>
                  <td>{{$v->created_at}}</td>
                  <td>{{$status}}</td>
                  <td><a href="{{asset('uploads/'.$v->file)}}" target="popup" 
  onclick="window.open('{{asset('uploads/'.$v->file)}}','popup','width=600,height=600'); return false;"><span style="color:white" class="me-1 badge bg-primary">{{$v->file}}</span></a></td>
                  <td width="10%"><a data-toggle="modal" data-target="#view{{$v->id}}"class="btn btn-primary btn-sm white"><i class="fa fa-file"></i></a></td>
                </tr>
                <div id="view{{$v->id}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                      <h4 class="modal-title">Ringkasan Izin Dinas</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <div style="display: flex;flex-direction:column">
                          <p>Nama : {{$pegawai->nama}}</p>
                          <p>NIP  : {{$pegawai->nip}}</p>
                          <p>NO SPT  : {{$v->nospt}}</p>
                          <p>HAL  : {{$v->alasan}}</p>
                          <p>Rentang Dinas  : {{$v->rentang_absen}}</p>
                          <p>Tanggal Pengajuan  : {{$v->created_at}}</p>
                          <p>Dicek BKPP  : {{$status}}</p>
                        </div>
                      </div>
                      <div class="modal-footer">
                      
                      </div>
                    </div>

                  </div>
                </div>
                
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>


    </div>
  </div>
  </div>
  <div class="modal fade" id="tambah" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Pegawai</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>

        <div class="modal-body">
          <form action="{{ url('addpegawai') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Foto</label>
              <br>
              <center>
                <image id="preview" src="{{ asset('noimage.png') }}"
                  style="width:200px;height:220px;">
              </center>
              <br>
              <br>
              <input type="hidden" name="logold" value="">
              <input type="file" name="file" id="file" onchange="tampilkanPreview(this,'preview')">
              <script>
                function tampilkanPreview(gambar, idpreview) {
                  //membuat objek gambar
                  var gb = gambar.files;
                  //loop untuk merender gambar
                  for (var i = 0; i < gb.length; i++) {
                    //bikin variabel
                    var gbPreview = gb[i];
                    var imageType = /image.*/;
                    var preview = document.getElementById(idpreview);
                    var reader = new FileReader();
                    if (gbPreview.type.match(imageType)) {
                      //jika tipe data sesuai
                      preview.file = gbPreview;
                      reader.onload = (function (element) {
                        return function (e) {
                          element.src = e.target.result;
                        };
                      })(preview);
                      //membaca data URL gambar
                      reader.readAsDataURL(gbPreview);
                    } else {
                      //jika tipe data tidak sesuai
                      alert("Type file tidak sesuai. Khusus image.");
                      document.getElementById("file").value = "";
                    }
                  }
                }
              </script>
              <br>
            </div>

            <div class="form-group">
              <label>NIP</label>
              <input type="text" class="form-control" name="nip" value="">
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="nama" value="">
            </div>

            <div class="form-group">
              <label>Gelar Depan</label>
              <input type="text" class="form-control" name="gd" value="">
            </div>
            <div class="form-group">
              <label>Gelar Belakang</label>
              <input type="text" class="form-control" name="gb" value="">
            </div>
            <div class="form-group">
              <label>NO HP</label>
              <input type="text" class="form-control" name="nohp" value="">
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" value="">
            </div>

            <ul class="list-group">
              <button class="btn btn-primary" type="submit">Simpan</button>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>



</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection