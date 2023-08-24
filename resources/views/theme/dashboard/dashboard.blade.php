@extends('theme.Layouts.design')
@section('content')
<?php
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

 ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      <p>A free and open source Bootstrap 4 admin template</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
        <div class="info">
          <h4>Anggota</h4>
          <p><b>{{ $pegawai }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
        <div class="info">
          <h4>IZIN DINAS</h4>
          <p><b>{{ $D }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
        <div class="info">
          <h4>Izin Sakit</h4>
          <p><b>{{ $S }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
        <div class="info">
          <h4>Izin Cuti</h4>
          <p><b>{{ $L }}</b></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">

    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title">Kordinat</h3>

          <div class="peta" id="peta" style="margin-top:2px;width:100%;height:500px;"></div>

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


          // icon: "https://bengkaliskab.go.id/gis/images/building.png"


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
    </div>
  </div>
</main>


@endsection
