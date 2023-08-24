@extends('theme.Layouts.design')
@section('content')
<?php
use App\Cmenu;
use App\KordinatModel;
use App\AbsenModel;
 ?>

 @if(isset($_GET['view']))
 @php
 $class = new Cmenu();

 $data_a = AbsenModel::where('id_absen',$_GET['view'])->first();
 $kantor = (object)$class->datamarker($data_a->kode_unitkerja);
 $pegawai = $class->getpegawaifromidusers($data_a->id_pegawai);
 @endphp
 <main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-calendar"></i> Data Absensi</h1>
      <p></p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
 

  @if($data_a->status=='C')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <a href="#" onclick="goBack()" style="float:right;color:white" class="btn btn-danger"><i class="fa fa-times"></i></a>
          <div style="display:flex;flex-direction:row;gap:20px;">
             <div style="display: flex;flex-direction:column">
              <p>Nama:</p>
              <p>{{ $pegawai->nama }}</p>
             </div>
             <div style="display: flex;flex-direction:column">
              <p>Keterangan:</p>
              <p>{{ $data_a->keterangan }}</p>
             </div>
             
          </div>
          
        </div>
        <div class="card-body">
          <?php
          $url = 'https://absensi.bengkaliskab.go.id';
          ?>
          <iframe src="{{ $url.'/uploads/'.$data_a->file }}" width="100%" height="500"></iframe>
        </div>
      </div>
    </div>
  </div>
  
  
  @elseif($data_a->status!=='C' || $data_a->status!=='P' || $data_a->status!=='D')
  <div class="row">
  <div class="col-7">
    <div class="card">
      <div class="card-header">
       
        <h4 class="card-title"><i class="fa fa-person"></i>{{$pegawai->gd.' '.$pegawai->nama.' '.$pegawai->gb}}</h4>
  
  
        <h6 class="card-subtitle">
          Data absensi ini di record berdasarkan record pegawai yang melakukan absensi
        </h6>
  
      </div>
      <div class="card-body">
        <div class="container">
        <div class="row">
          <div  class="col-md-6">
            <label>Tgl Absen</label>
            <input type="text" class="form-control" disabled value="{{$data_a->time}}">
            <label>Status</label>
            <input type="text" class="form-control" disabled value="{{$data_a->keterangan}}">
            <label>Jenis Absen</label>
            <input type="text" class="form-control" disabled value="{{$data_a->jenis}}">
  
          </div>
          <div  class="col-md-6">
            <img class="responsive" src="/public/swafoto/{{$data_a->kode_unitkerja}}/{{$data_a->swafoto}}" alt="">
          </div>
        </div>
      </div>
       
      </div>
      <div class="card-footer">
        
      </div>
  
    </div>
  </div>
  
  <div class="col-5">
    <div class="card">
      <div class="card-header">
       
        <a href="#" onclick="goBack()" style="float:right;color:white" class="btn btn-danger"><i class="fa fa-times"></i></a>
       
        <h4 class="card-title"><i class="fa fa-person"></i>Lokasi Absensi</h4>
  
  
        <h6 class="card-subtitle">
          Lokasi ini berdasarkan dari rekaman smartphone pegawai bersangkutan
        </h6>
  
      </div>
      <style>
        #map {
    height: 34vh;
  }
  
      </style>
      <div class="card-body">
        <div class="container">
          <div id="map"></div>
  
         <!-- Include the Google Maps API script -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwxUvl3u_d_3fdomak3SKTITmJqQaDXak&callback=initMap" async defer></script>
  <!-- Replace YOUR_API_KEY with your actual Google Maps API key -->
  
  <script>
    let map;
  
    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: {{$data_a->latitude}}, lng: {{$data_a->longitude}} },
        zoom: 20,
      });
  
      // Create a marker at the specified coordinates
      const marker = new google.maps.Marker({
        position: { lat: {{$data_a->latitude}}, lng: {{$data_a->longitude}} },
        map: map,
        title: "Marker Title", // Replace with the desired title for the marker
        // icon: 'path/to/custom_icon.png' // If you want to use a custom icon, specify the path here
      });
  
      const circle = new google.maps.Circle({
        map: map,
        center: { lat: {{$kantor->latitude}}, lng: {{$kantor->longitude}} },
        radius: {{$kantor->radius}}, // Replace with the desired radius in meters
        strokeColor: "#FF0000", // Circle border color (red in this example)
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000", // Circle fill color (red in this example)
        fillOpacity: 0.35,
      });
    }
  </script>
  
      </div>
       
      </div>
      <div class="card-footer">
        
      </div>
  
    </div>
  </div>
  </div>
  
  @endif


</main>


 @else
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-calendar"></i> Data Absensi</h1>
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
    <div class="card-header">
      <div id="cetak" class="modal fade" role="dialog">
        <div class="modal-dialog">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cetak Laporan Absensi</h4>

              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('cetakabsensi')}}" method="post">
            <div class="modal-body">
              <label>Pilih Perangkat Daerah</label>
              <select  class="form-control""
                            name="skpd">
                            @foreach($skpd as $i =>$v)
                            <option value="{{$v->kode_unitkerja}}">{{$v->nama_unitkerja}}</option>
                            @endforeach
                        </select>
              <p>Tentukan tanggal Periode Cetak</p>
              <div style="display: flex; flex-direction: row;">
                <input type="date" name="from" class="form-control" required>
                <p>s/d</p>
                <input type="date" name="to" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Cetak</button>
            </div>
            </form>
          </div>
      
        </div>
      </div>
      <a data-toggle="modal" data-target="#cetak" style="float:right;color:white" class="btn btn-primary"><i class="fa fa-print"></i> Cetak data</a>
     
      <select id="jenisabsen" class="form-control" style="width:20%;float:right;margin-right:2px;" name="jenis">
       
        <option value="M">Masuk</option>
        <option value="P">Pulang</option>
      </select>
      <select id="skpd" class="form-control" style="width:20%;float:right;margin-right:2px;"
                            name="skpd">
                            @foreach($skpd as $i =>$v)
                            <option value="{{$v->kode_unitkerja}}">{{$v->nama_unitkerja}}</option>
                            @endforeach
                        </select>
      <input id="tgl"  style="width:20%;float:right;margin-right:2px;" type="date" name="tgl" class="form-control" value="{{  date('Y-m-d') }}">
    <h4 class="card-title"><i class="fa fa-calendar"></i> Data Absensi</h4>


      <h6 class="card-subtitle">
        Data absensi ini di record berdasarkan record pegawai yang melakukan absensi
      </h6>

    </div>
    <div class="card-body">
      
      <br>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="tableabsen">
          <thead>
            <tr>
            <th rowspan="2" style="text-align:center">No</th>
            <th rowspan="2" style="text-align:center">Nama</th>
            <th rowspan="2" style="text-align:center">Pangkat/Gol</th>
            <th rowspan="2" style="text-align:center">Waktu Absen</th>
            <th colspan="8" style="text-align:center">Keterangan</th>
            
          </tr>
          <tr>
            <th style="text-align:center">H</th>
            <th style="text-align:center">D</th>
            <th style="text-align:center">C</th>
            <th style="text-align:center">S</th>
            <th style="text-align:center">A</th>
            <th style="text-align:center">P</th>
            <th style="text-align:center">aksi</th>

          </tr>
        </thead>
        </table>
      </div>
    </div>
  </div>
</div>
</div>



</main>
<script>
  function reset(id) {

    swal({
        title: "Anda yakin mereset absensi ini ??",
        text: "Status absensi akan tereset dan data yang di rekam sebelumnya akan hilang. penting untuk melakukan aksi selanjutnya agar tidak menjadi status tanpa keterangan / Alpha",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Reset!",
        closeOnConfirm: false
      },
      function () {
        swal("Aksi reset dilakukan!", "", "success")
        window.location = '{{ url("resetabsensi") }}/' + id;

      }



    );

    }
    </script>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    var jenis = document.getElementById('jenisabsen').value;
    var tgl   = $(this).val();
    var skpd = document.getElementById('skpd').value;
      $('#tableabsen').DataTable({
          processing: true,
          retrieve: true,
          serverSide: true,
          ajax: "{{ url('apiabsen') }}?skpd="+skpd+"&tanggalabsen="+tgl+"&jenisabsen="+jenis,
          columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama'
                    },
                    {
                        data: 'pangkat',
                        name: 'Pangkat/Gol'
                    },
                    {
                        data: 'waktu_absen',
                        name: 'waktu_absen'
                    },
                    {
                        data: 'H',
                        name: 'H'
                    },{
                        data: 'D',
                        name: 'D'
                    },{
                        data: 'C',
                        name: 'C'
                    },{
                        data: 'S',
                        name: 'S'
                    },{
                        data: 'A',
                        name: 'A'
                    },{
                        data: 'P',
                        name: 'P'
                    },{
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
      });
  });
  $('#tgl').change(function(){
    var jenis = document.getElementById('jenisabsen').value;
    var tgl   = $(this).val();
    var skpd = document.getElementById('skpd').value;
    var table = document.getElementById('tableabsen');
		$('#tableabsen').DataTable({
          destroy: true,
          processing: true,
          serverSide: true,
          ajax: "{{url('getdataabsenfromjenis')}}?skpd="+skpd+"&jenisabsen="+jenis+"&tanggalabsen="+tgl,
          columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama'
                    },
                    {
                        data: 'pangkat',
                        name: 'Pangkat/Gol'
                    },
                    {
                        data: 'waktu_absen',
                        name: 'waktu_absen'
                    },
                    {
                        data: 'H',
                        name: 'H'
                    },{
                        data: 'D',
                        name: 'D'
                    },{
                        data: 'C',
                        name: 'C'
                    },{
                        data: 'S',
                        name: 'S'
                    },{
                        data: 'A',
                        name: 'A'
                    },{
                        data: 'P',
                        name: 'P'
                    },{
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
      });
  });
	$('#jenisabsen').change(function() {
    
		var jenis = $(this).val();
    var tgl   = document.getElementById('tgl').value;
    var skpd = document.getElementById('skpd').value;
    var table = document.getElementById('tableabsen');
		$('#tableabsen').DataTable({
          destroy: true,
          processing: true,
          serverSide: true,
          ajax: "{{url('getdataabsenfromjenis')}}?skpd="+skpd+"&jenisabsen="+jenis+"&tanggalabsen="+tgl,
          columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama'
                    },
                    {
                        data: 'pangkat',
                        name: 'Pangkat/Gol'
                    },
                    {
                        data: 'waktu_absen',
                        name: 'waktu_absen'
                    },
                    {
                        data: 'H',
                        name: 'H'
                    },{
                        data: 'D',
                        name: 'D'
                    },{
                        data: 'C',
                        name: 'C'
                    },{
                        data: 'S',
                        name: 'S'
                    },{
                        data: 'A',
                        name: 'A'
                    },{
                        data: 'P',
                        name: 'P'
                    },{
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
      });
	});

  $('#skpd').change(function() {
    
		var jenis = document.getElementById('jenisabsen').value;
    var tgl   = document.getElementById('tgl').value;
    var skpd = $(this).val();
    var table = document.getElementById('tableabsen');
		$('#tableabsen').DataTable({
          destroy: true,
          processing: true,
          serverSide: true,
          ajax: "{{url('getdataabsenfromjenis')}}?skpd="+skpd+"&jenisabsen="+jenis+"&tanggalabsen="+tgl,
          columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama'
                    },
                    {
                        data: 'pangkat',
                        name: 'Pangkat/Gol'
                    },
                    {
                        data: 'waktu_absen',
                        name: 'waktu_absen'
                    },
                    {
                        data: 'H',
                        name: 'H'
                    },{
                        data: 'D',
                        name: 'D'
                    },{
                        data: 'C',
                        name: 'C'
                    },{
                        data: 'S',
                        name: 'S'
                    },{
                        data: 'A',
                        name: 'A'
                    },{
                        data: 'P',
                        name: 'P'
                    },{
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
      });
	});
 
</script>
@endif
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
