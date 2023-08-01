@extends('theme.Layouts.design')
@section('content')
<?php
use App\Cmenu;
use App\KordinatModel;
use App\AbsenModel;
 ?>
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
      <!--<a data-toggle="modal" data-target="#cuti" style="float:right;color:white"class="btn btn-danger"><i class="fa fa-file"></i> Izin Cuti</a>

      <div id="cuti" class="modal fade" role="dialog">
        <div class="modal-dialog">
       
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Izin CUTI</h4>
              <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('ajukanizin')}}" method="post" enctype="multipart/form-data">{{csrf_field()}}
            <div class="modal-body">
              <input type="hidden" name="jenis" value="C">
              <input type="hidden" name="kat" value="A">
              <label>No SURAT</label>
              <input type="text" class="form-control" name="nosurat" value="">
              <label>Pegawai</label>
              <select class="form-control select2" name="pg[]" id="exampleSelect2" multiple=""
                      style="width: 100%;color:white;">
                @foreach ($pg as $index => $d)
                <option value="{{$d['no']}}" >{{$d['gd'].$d['nama'].$d['gb']}}</option>
                @endforeach
              </select>
              <label>Tanggal</label>
               <div class="row" style="margin-left:2px;">
                 <input type="date" class="form-control" name="awal" style="width:40%">
                  S/D
                 <input type="date" class="form-control" name="akhir" style="width:40%">
               </div>
              <label>File SPT (Format PDF Max Size : 200kb)</label>
              <input type="file" class="form-control" name="file" value="">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>

        </div>
      </div>

      <a data-toggle="modal" data-target="#sakit" style="float:right;color:white;margin-right:2px;"class="btn btn-warning"><i class="fa fa-file"></i> Izin Sakit</a>
      <div id="sakit" class="modal fade" role="dialog">
        <div class="modal-dialog">

    
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Izin Sakit</h4>
              <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('ajukanizin')}}" method="post" enctype="multipart/form-data">{{csrf_field()}}
            <div class="modal-body">
              <input type="hidden" name="jenis" value="S">
              <input type="hidden" name="kat" value="A">
              <label>No Surat</label>
              <input type="text" class="form-control" name="nosurat" value="">
              <label>Pegawai</label>
              <select class="form-control select2" name="pg[]" id="exampleSelect2" multiple=""
                      style="width: 100%;color:white;">
                @foreach ($pg as $index => $d)
                <option value="{{$d['no']}}" >{{$d['gd'].$d['nama'].$d['gb']}}</option>
                @endforeach
              </select>
              <label>Tanggal</label>
               <div class="row" style="margin-left:2px;">
                 <input type="date" class="form-control" name="awal" style="width:40%">
                  S/D
                 <input type="date" class="form-control" name="akhir" style="width:40%">
               </div>
              <label>File Surat Sakit (Format PDF Max Size : 200kb)</label>
              <input type="file" class="form-control" name="file" value="">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>

        </div>
      </div>
      <a data-toggle="modal" data-target="#dinas" style="float:right;color:white;margin-right:2px;"class="btn btn-info"><i class="fa fa-file"></i> Izin Dinas</a>


      <div id="dinas" class="modal fade" role="dialog">
        <div class="modal-dialog">
          
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Izin Dinas</h4>
              <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('ajukanizin')}}" method="post" enctype="multipart/form-data">{{csrf_field()}}
            <div class="modal-body">
              <input type="hidden" name="jenis" value="D">
              <input type="hidden" name="kat" value="A">
              <label>No SPT</label>
              <input type="text" class="form-control" name="nosurat" value="">
              <label>Pegawai</label>
              <select class="form-control select2" name="pg[]" id="exampleSelect2" multiple=""
                      style="width: 100%;color:white;">
                @foreach ($pg as $index => $d)
                <option value="{{$d['no']}}" >{{$d['gd'].$d['nama'].$d['gb']}}</option>
                @endforeach
              </select>
              <label>Tanggal</label>
               <div class="row" style="margin-left:2px;">
                 <input type="date" class="form-control" name="awal" style="width:40%">
                  S/D
                 <input type="date" class="form-control" name="akhir" style="width:40%">
               </div>
              <label>File SPT (Format PDF Max Size : 200kb)</label>
              <input type="file" class="form-control" name="file" value="">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>

        </div>
      </div>-->
      <a style="float:right;color:white" class="btn btn-primary"><i class="fa fa-print"></i> Cetak data</a>
      <select id="jenisabsen" class="form-control" style="width:20%;float:right;margin-right:2px;" name="jenis">
        <option>--Jenis Absensi--</option>
        <option value="M">Masuk</option>
        <option value="K">Keluar</option>
      </select>
      <input id="tgl" style="width:20%;float:right;margin-right:2px;" type="date" name="tgl" class="form-control">
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
            <th rowspan="2" style="text-align:center">Latitude / Longitude</th>
            <th rowspan="2" style="text-align:center">IP</th>
            <th rowspan="2" style="text-align:center">Status</th>
            <th colspan="7" style="text-align:center">Keterangan</th>
            <th  width="10%" style="text-align:center">Aksi</th>
          </tr>
          <tr>
            <th style="text-align:center">H</th>
            <th style="text-align:center">D</th>
            <th style="text-align:center">I</th>
            <th style="text-align:center">C</th>
            <th style="text-align:center">S</th>
            <th style="text-align:center">A</th>
            <th style="text-align:center">P</th>
            <th style="text-align:center"></th>

          </tr>
        </thead>
        <tbody>
          @foreach($pg as $i => $v)
          @php
            $absensi = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->first();
          @endphp
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ ((empty($v->gd) OR $v->gd == '-') ? '':$v->gd).''.$v->nama.' '.$v->gb }}</td>
            <td></td>
            <td>{{ (!empty($absensi->tglabsen)) ? print $absensi->tglabsen:"Belum Absen" }}</td>
            <td>{{ (!empty($absensi->latitude)) ? print $absensi->latitude.','.$absensi->longitude:"-" }}</td>
            <td></td>
            <td></td>
            <td><i  style="color:green" class="fa fa-check"></i></td>
            <td><i  style="color:green" class="fa fa-check"></i></td>
            <td><i  style="color:green" class="fa fa-check"></i></td>
            <td><i  style="color:green" class="fa fa-check"></i></td>
            <td><i  style="color:green" class="fa fa-check"></i></td>
            <td><i  style="color:green" class="fa fa-check"></i></td>
            <td><i  style="color:green" class="fa fa-check"></i></td>
            <td>
              <a  style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> lihat abensi</a>
            </td>
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
      $('#tableabsen').DataTable({
          ajax: '../ajax/data/arrays.txt',
      });
  });
	$('#jenisabsen').change(function() { 
		var jenis = $(this).val();
    var tgl   = document.getElementById('tgl').value;
		$.ajax({
			type: 'POST', 
			url: "{{ url('getdataabsenfromjenis') }}", 
			data: { "_token": "{{ csrf_token() }}","jenisabsen": jenis,"tanggalabsen":tgl}, 
			success: function(response) { 
				//$('#jurusan').html(response); 
        alert(response);
			}
		});
	});
 
</script>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
