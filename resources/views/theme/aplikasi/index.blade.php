@extends('theme.Layouts.design')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Users</h1>
      <p>Untuk mengatur user Aplikasi</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
<div class="row">
<div class="col-8">
  <div class="card">
    <div class="card-body">
      <button style="float:right;"class="btn btn-primary" data-toggle="modal" data-target="#updatepass"><i class="fa fa-lock"></i> Update Password</button>

      <h4 class="card-title">Pengaturan Aplikasi</h4>

      <h6 class="card-subtitle">Mengatur Aplikasi<h6>

      <form action="{{url('setAplikasi/update')}}" method="post" enctype="multipart/form-data">{{csrf_field()}}
        <div class="form-group">
        <label>Logo</label>
        <br>
        <image id="preview" src="{{asset('theme/aplikasi/'.$data->logo)}}" style="width:200px;height:200px;">
        <br>
        <br>
        <input type="hidden" name="logold" value="{{$data->logo}}">
        <input type="file"  name="file" id="file"  onchange="tampilkanPreview(this,'preview')">
        <script>
        function tampilkanPreview(gambar,idpreview){
          //membuat objek gambar
            var gb = gambar.files;
          //loop untuk merender gambar
              for (var i = 0; i < gb.length; i++){
                //bikin variabel
                  var gbPreview = gb[i];
                  var imageType = /image.*/;
                  var preview=document.getElementById(idpreview);
                  var reader = new FileReader();
                    if (gbPreview.type.match(imageType)) {
                    //jika tipe data sesuai
                      preview.file = gbPreview;
                      reader.onload = (function(element) {
                        return function(e) {
                            element.src = e.target.result;
                        };
                      })(preview);
                      //membaca data URL gambar
                      reader.readAsDataURL(gbPreview);
                    }
                    else{
                    //jika tipe data tidak sesuai
                      alert("Type file tidak sesuai. Khusus image.");
                      document.getElementById("file").value = "";
                    }
              }
        }
        </script>
        <br>
        <label>Nama Aplikasi </label>
        <input type="hidden" value="{{$data->id_app}}" name="id" class="form-control" required>
        <input type="text" value="{{$data->app_name}}" name="nama" class="form-control" required>
        <br>
        <label>Warna Aplikasi </label>
        <input class="form-control" value="{{$data->color}}" name="color" style="width:100px;height:100px;" type="color">
        <button style="float:right;"class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="col-4">
  <div class="card">
    <div class="card-body">
      <div class="row">
            <div class="col-md-8 col-md-offset-2"> 
                    
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
              
            </div>
        </div>
    </div>
  </div>
</div>

</div>
</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
