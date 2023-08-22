<?php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
?>
@extends('theme.Layouts.design')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Kordinat Luar Kantor</h1>
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
     <a data-toggle="modal" data-target="#myModal" style="float:right" class="btn btn-primary" href="">Tambah Qr Code</a>
    <h4 class="card-title">Kordinat Luar Kantor</h4>

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
      <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Lokasi Absensi Luar Kantor</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <form method="post" action="{{ url('absenmanualsave') }}"> @csrf
      <div class="modal-body">
        <label>Tempat</label>
        <input type="text" class="form-control" required name="tempat">
        <label>Waktu Berlaku</label>
        <div style="display:flex;flex-direction:row;gap:2px;width:100%">
            <div style="width:100%">
            <input class="form-control" type="datetime-local" id="datetime" name="start">
            <i>Mulai Absensi</i>
            </div>
            <div style="width:100%">
                <input class="form-control" type="datetime-local" id="datetime" name="end">
            <i>Batas Absensi</i>
            </div>
            
        </div>
        <label>Kordinat</label>
        <div style="display:flex;flex-direction:row;gap:2px;width:100%">
            <div style="width:100%">
            <input class="form-control" type="text" name="latitude" placeholder="latitude">
            </div>
            <div style="width:100%">
                <input class="form-control" type="text" name="longitude" placeholder="longitude">
            </div>
            
        </div>
        <label>Radius</label>
        <input type="number" class="form-control" name="radius" required>
        
        
      </div>
  
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>

  </div>
</div>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
            <th>No</th>
            <th>Qr Code</th>
            <th>Tempat</th>
            <th>Waktu Berlaku</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Radius</th>
            <th width="10%"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $v)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ QrCode::generate($v->qr_code) }}</td>
                <td>{{ $v->nama_tempat }}</td>
                <td>{{ $v->start }} s/d {{ $v->end }}</td>
                <td>{{ $v->latitude }}</td>
                <td>{{ $v->longitude }}</td>
                <td>{{ $v->radius }}</td>
                <td>
                    <a data-toggle="modal" data-target="#my{{ $v->id_luarkantor }}" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                    <a onclick="hapus('{{ base64_encode($v->id_luarkantor) }}')"  style="color:white" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <script>
                function hapus(id) {
                swal({
                    title: "Anda yakin akan menghapus Lokasi ini ??",
                    text: "Data yang dihapus tidak dapat di kembalikan",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false
                },
                function () {
                    swal("Lokasi Dihapus!", "", "success")
                    window.location = '{{ url("hapusluarkantor") }}/' + id;

                }



                );

                }
            </script>
            <div id="my{{ $v->id_luarkantor }}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Lokasi Absensi Luar Kantor</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <form method="post" action="{{ url('absenmanualupdate') }}"> @csrf
        <input type="hidden" name="id" value="{{ $v->id_luarkantor }}">
      <div class="modal-body">
        <label>Tempat</label>
        <input type="text" class="form-control" required name="tempat" value="{{ $v->nama_tempat }}">
        <label>Waktu Berlaku</label>
        <div style="display:flex;flex-direction:row;gap:2px;width:100%">
            <div style="width:100%">
            <input class="form-control" type="datetime-local" id="datetime" name="start" value="{{ $v->start }}">
            <i>Mulai Absensi</i>
            </div>
            <div style="width:100%">
                <input class="form-control" type="datetime-local" id="datetime" name="end" value="{{ $v->end }}">
            <i>Batas Absensi</i>
            </div>
            
        </div>
        <label>Kordinat</label>
        <div style="display:flex;flex-direction:row;gap:2px;width:100%">
            <div style="width:100%">
            <input class="form-control" type="text" name="latitude" placeholder="latitude" value="{{ $v->latitude }}">
            </div>
            <div style="width:100%">
                <input class="form-control" type="text" name="longitude" placeholder="longitude" value="{{ $v->longitude }}">
            </div>
            
        </div>
        <label>Radius</label>
        <input type="number" class="form-control" name="radius" value="{{ $v->radius }}" required>
        
        
      </div>
  
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>

  </div>
</div>



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
