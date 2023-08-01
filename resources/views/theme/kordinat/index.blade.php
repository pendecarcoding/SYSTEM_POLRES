@extends('theme.Layouts.design')
@section('content')
<?php
use App\Cmenu;
use App\KordinatModel;
$class = new Cmenu();
$datamarker = KordinatModel::where('latitude','!=','')
              ->where('longitude','!=','')
              ->get();
 ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Data Kordinat</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>

<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      @if(isset($_GET['view']) AND $_GET['view']=='maps')
      <a href="{{url('titikkordinat')}}" class="btn btn-info" style="float:right;color:white"><i class="fa fa-list"></i> Data List</a>
      @else
      <a href="{{url('titikkordinat?view=maps')}}" class="btn btn-info" style="float:right;color:white"><i class="fa fa-map-marker"></i> Maps</a>
      @endif
    <h4 class="card-title">Data Kordinat</h4>

      <h6 class="card-subtitle"></h6>

      <br>
      @if(isset($_GET['view']) AND $_GET['view']=='maps')
      <div class="peta" id="peta" style="margin-top:2px;width:100%;height:500px;"></div>

 <script>
function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('peta'), {
    center: {lat: 1.742532, lng: 101.828892},
    radius: 100,
    zoom: 9,
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
      @else
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
            <th>No</th>
            <th>Intansi</th>
            <th>Kecamatan</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Radius</th>
            <th width="10%"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($listintansi as $index =>$v)
          @if($v['nama_unitkerja'] != '')
          <?php
            $ckordinat = KordinatModel::where('kode_unitkerja',$v['kode_unitkerja'])->count();
            $kordinat = KordinatModel::where('kode_unitkerja',$v['kode_unitkerja'])->first();
           ?>
          <tr>
          <td>{{$index+1}}</td>
          <td>{{$v['nama_unitkerja']}}</td>
          <td>{{$v['kecamatan']}}</td>
          <td>@if($ckordinat > 0){{$kordinat->latitude}}@endif</td>
          <td>@if($ckordinat > 0){{$kordinat->longitude}}@endif</td>
          <td>@if($ckordinat > 0){{$kordinat->radius}}@endif</td>
          <td width="10%">
            <?php
              $ckordinat = KordinatModel::where('kode_unitkerja',$v['kode_unitkerja'])->count();
              if($ckordinat == 0){
                ?>
                <a data-toggle="modal" data-target="#titik{{$v['kode_unitkerja']}}" style="color:white"class="btn btn-info btn-sm">Input</a>
                <?php
              }
              else if($ckordinat > 0 AND Session::get('id_user')==$kordinat['id_user'] OR Session::get('level')=='admin' OR Session::get('level')=='BKPP'){
                $kordinat = KordinatModel::where('kode_unitkerja',$v['kode_unitkerja'])->first();

                ?>
                 <a data-toggle="modal" data-target="#titik{{$v['kode_unitkerja']}}" style="color:white"class="btn btn-warning btn-sm">Edit</a>
                 <?php
               }else if($ckordinat > 0 AND Session::get('id_user') != $kordinat['id_user']){
                 ?>
                 
                 <a style="color:white"class="btn btn-danger btn-sm"><i class="fa fa-ban"></i></a>


                 <?php
                }
                  ?>

            <?php
              $ckordinat = KordinatModel::where('kode_unitkerja',$v['kode_unitkerja'])->count();
              if($ckordinat > 0){
                $kordinat = KordinatModel::where('kode_unitkerja',$v['kode_unitkerja'])->first();

                ?>

                <div id="titik{{$v['kode_unitkerja']}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Masukan Data Kordinat</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <form  action="{{url('addkordinat')}}" method="post">{{csrf_field()}}

                        </div>
                        <div class="modal-body">
                          <label>Latitude</label>
                          <input type="hidden" name="kode_unitkerja" value="{{$v['kode_unitkerja']}}">
                          <input type="hidden" name="id_kordinat" value="{{$kordinat['id_kordinat']}}">
                          <input type="text" class="form-control" name="latitude" value="{{$kordinat->latitude}}">
                          <label>Longitude</label>
                          <input type="text" class="form-control" name="longitude" value="{{$kordinat->longitude}}">
                          <label>Radius</label>
                          <input type="number" class="form-control" name="radius" value="{{$kordinat->radius}}">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-info">Simpan</button>
                        </div>


                      </div>
  </form>
                    </div>
                  </div>
                <?php
              }else{
                ?>
                <div id="titik{{$v['kode_unitkerja']}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Masukan Data Kordinat</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <form  action="{{url('addkordinat')}}" method="post">{{csrf_field()}}

                        </div>
                        <div class="modal-body">
                          <label>Latitude</label>
                          <input type="hidden" name="kode_unitkerja" value="{{$v['kode_unitkerja']}}">
                          <input type="hidden" name="id_kordinat" value="null">
                          <input type="text" class="form-control" name="latitude" value="">
                          <label>Longitude</label>
                          <input type="text" class="form-control" name="longitude" value="">
                          <label>Radius</label>
                          <input type="number" class="form-control" name="radius" value="">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-info">Simpan</button>
                        </div>


                      </div>
                        </form>

                    </div>
                  </div>
                <?php
              }
            ?>
          </td>
        </tr>
        @endif
         @endforeach
        </tbody>
        </table>
      </div>
      @endif

    </div>
  </div>
</div>
</div>



</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
