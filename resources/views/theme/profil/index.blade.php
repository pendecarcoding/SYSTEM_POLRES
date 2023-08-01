@extends('theme.Layouts.design')
@section('content')
@php
use App\Cmenu;
use App\KordinatModel;
$class = new Cmenu();
if(Session::get('level')=='user'){
  $datamarker = KordinatModel::where('latitude','!=','')
                ->where('longitude','!=','')
                ->where('kode_unitkerja',Session::get('kode_unitkerja'))
                ->get();
  $centermarker = KordinatModel::where('latitude','!=','')
                ->where('longitude','!=','')
                ->where('kode_unitkerja',Session::get('kode_unitkerja'))
                ->first();
  $clatitude   = $centermarker->latitude;
  $clongitude  = $centermarker->longitude;

   $zoom = 20;
}else{
  $datamarker = KordinatModel::where('latitude','!=','')
                ->where('longitude','!=','')
                ->get();
  $clatitude   = '1.583164915316166';
  $clongitude  = '101.81656018345798';
   $zoom = 9;
}




@endphp
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
<div class="col-4">
  <div class="card">
    <div class="card-body">
      <button style="float:right;"class="btn btn-primary" data-toggle="modal" data-target="#updatepass"><i class="fa fa-lock"></i> Update Password</button>
      <!-- Modal -->
<div id="updatepass" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <form action="{{url('updatepass')}}" method="post">{{csrf_field()}}
          <label>Password Lama</label>
          <input type="hidden" value="{{$data->id_user}}" name="id" class="form-control" required>
          <input type="password" class="form-control" name="passlama" placeholder="Password Lama" required>
          <label>Password Baru</label>
          <input type="password" class="form-control" name="passbaru" placeholder="Password Baru" required>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>

  </div>
</div>
      <h4 class="card-title">Data Profil</h4>
      <h6 class="card-subtitle">Setting Akun Profil</h6>
      <form action="{{url('settingprofil/update')}}" method="post" enctype="multipart/form-data">{{csrf_field()}}
        <div class="form-group">
        <label>Foto</label>
        <br>
        <center>
          <image id="preview" src="{{asset('theme/users/'.$data->foto)}}" style="width:200px;height:200px;">
          </center>
            <br>
        <br>
        <input type="hidden" name="logold" value="{{$data->foto}}">
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
        <label>Nama </label>
        <input type="hidden" value="{{$data->id_user}}" name="id" class="form-control" required>
        <input type="text" value="{{$data->nama}}" name="nama" class="form-control" required>

        <label>Username</label>
        <input type="text" value="{{$data->username}}" name="username" class="form-control" required>
        <label>Alamat</label>
        <input type="text" value="{{$data->alamat}}" name="alamat" class="form-control" required>
        <label>Email</label>
        <input type="text" value="{{$data->email}}" name="email" class="form-control" required>
        <label>No Hp</label>
        <input type="text" value="{{$data->nohp}}" name="nohp" class="form-control" required>

        <br>
        <button style="float:right;"class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="col-8">
  <div class="card">
    <div class="card-body">
      <div class="tile">
        <h3 class="tile-title">Kordinat</h3>

          <div class="peta" id="peta" style="margin-top:2px;width:100%;height:300px;"></div>

          <script>
          function initAutocomplete() {
          var map = new google.maps.Map(document.getElementById('peta'), {
          center: {lat: {{$clatitude}}, lng: {{$clongitude}}},
          zoom: {{$zoom}},
          mapTypeId: 'terrain'

          });

          // Create the search box and link it to the UI element.
          var input = document.getElementById('pac-input');
          var searchBox = new google.maps.places.SearchBox(input);
          map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

          // Bias the SearchBox results towards current map's viewport.
          map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());

          });

          var markers = [];
          // Listen for the event fired when the user selects a prediction and retrieve
          // more details for that place.
          searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
          return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
          marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          // Create a marker for each place.
          markers.push(new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location
          }));

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
          });
          map.fitBounds(bounds);
          });
          var locations = [

          @foreach($datamarker as $key => $v)
          <?php
          $instansi = $class->namainstansi($v->kode_unitkerja);
          ?>
          ['<h4><b style="color:red;">{{$instansi->nama_unitkerja}}</b></h4><hr><br><b>Kode Unitkerja </b>: </b> {{$v->kode_unitkerja}}<br><b>Kecamatan</b> : {{$instansi->kecamatan}}<br><b>Alamat</b> : {{$instansi->alamat}}<br><b>Radius</b> : <b style="color:red;">{{$v->radius}} meter</b><br><b>Latitude </b> : <b style="color:#ffae00;">{{$v->latitude}}</b><br><b>Longitude</b> : <b style="color:#ffae00;">{{$v->longitude}}</b>', {{$v->latitude}}, {{$v->longitude}},{{$v->radius}}],
          @endforeach

          ];




          var infowindow = new google.maps.InfoWindow();


          //

          var marker, i,circle;
          /* kode untuk menampilkan banyak marker */
          for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,


          icon: "https://bengkaliskab.go.id/gis/images/building.png"


          });

          circle = new google.maps.Circle({
          map: map,
          radius: locations[i][3],    // 10 miles in metres
          fillColor: '#b6e7bacc'
          });

          circle.bindTo('center', marker, 'position');

          /* menambahkan event clik untuk menampikan
          infowindows dengan isi sesuai denga
          marker yang di klik */

          google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
          }
          })(marker, i));
          }

          }

          </script>
          <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwxUvl3u_d_3fdomak3SKTITmJqQaDXak&libraries=places&callback=initAutocomplete"
          async defer></script>

      </div>
      <div><p style="font-style: italic">Kordinat ini ditetapkan oleh Badan Kepegawaian dan Pelatihan Pegawai</p></div>
    </div>
  </div>
</div>

</div>
</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
