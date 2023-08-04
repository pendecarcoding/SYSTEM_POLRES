@extends('theme.Layouts.design')
@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Data Pegawai</h1>
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
          <a data-toggle="modal" href="#tambah" data-target="#tambah" style="color:white;"
            class="btn waves-effect waves-light btn-primary pull-right"> <i class="fa fa-plus"></i> Tambah Data</a>
          <!--<a style="float: right;" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> Import Data </a>
          --><h4 class="card-title">Data Pegawai</h4>
        </div>
        <div class="card-body">


          <h6 class="card-subtitle"></h6>

          <br>
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th></th>
                  <th>Nama</th>
                  <th>Pangkat/Gol</th>
                  <th>No HP</th>
                  <th>Email</th>
                  <th width="10%"></th>
              </thead>
              <tbody>
                @foreach($data as $i =>$v)
                  <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                      <center>
                        <image
                          src="{{ asset('pegawai/'.Session::get('kode_unitkerja').'/'.$v->image) }}"
                          style="width:50px;height:60px;">
                      </center>
                    </td>
                    <td>@if($v->gd=='-') @else {{ $v->gd }}
                      @endif{{ $v->nama.','.$v->gb }}<br>{{ $v->nip }}</td>
                    <td></td>
                    <td>{{ $v->nohp }}</td>
                    <td>{{ $v->email }}</td>
                    <td>
                      <a data-toggle="modal" href="#tambah" data-target="#edit{{ $v->id }}" style="color:white"
                        class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                      <a onclick="konfirmasi('{{ base64_encode($v->id) }}')" style="color:white"
                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>

                  <script>
                    function konfirmasi(id) {

                      swal({
                          title: "Anda yakin hapus data ini?",
                          text: "Data yang dihapus tidak dapat di kembalikan !!!",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: "Ya, hapus data!",
                          closeOnConfirm: false
                        },
                        function () {
                          swal("data dihapus!", "", "success")
                          window.location = '{{ url("deletepegawai") }}/' + id;

                        }



                      );

                    }
                  </script>

                  @include('theme.pegawai.modal')

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
              <label>Pangkat/Gol</label>
              <input type="text" class="form-control" name="pangkat_gol" value="">
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