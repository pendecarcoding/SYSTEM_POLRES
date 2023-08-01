@extends('theme.Layouts.design')
@section('content')
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<div class="container-fluid">
<div class="row">
@if(isset($_GET['lihat']))
<?php
$profil = App\Gurumodel::where('id_guru',base64_decode($_GET['lihat']))->first();
$layanan = App\Gurumodel::join('jadwals','jadwals.id_guru','gurus.id_guru')
           ->join('kategorilayanans','kategorilayanans.id_kategorilayanan','jadwals.id_kategorilayanan')
           ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
           ->where('gurus.id_guru',$profil->id_guru)->get();
?>
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fas fa-calendar"></i> Daftar Jadwal Guru {{$profil->nama_guru}}
        <a href="{{url('jadwalmengajar')}}" class="btn btn-danger" style="float:right;color:white;"><i class="fas fa-times"></i></a></h4>
      <h6 class="card-subtitle">Data ini menunjukan jadwal dari guru {{$profil->nama_guru}}</h6>
      <!-- Modal -->
      <br>
      <hr />
  @foreach($layanan as $index => $v)
  <h6 style="color:black">Kategori Layanan : {{$v->kategorilayanan}}</h6>
  <h6 style="color:black">Kelas : {{$v->kategorimengajar}}</h6>
  <h6 style="color:black">Kuota : {{$v->kuota}} Siswa</h6>
  <table>
  <tr>
    <th><i class="fa fa-calendar"></i> Senin</th>
    <th><i class="fa fa-calendar"></i> Selasa</th>
    <th><i class="fa fa-calendar"></i> Rabu</th>
    <th><i class="fa fa-calendar"></i> Kamis</th>
    <th><i class="fa fa-calendar"></i> Jum'at</th>
    <th><i class="fa fa-calendar"></i> Sabtu</th>
    <th><i class="fa fa-calendar"></i> Ahad</th>
  </tr>
  <tr>
    <td>
      <?php
        $kalimat = explode(',',$v->hari);
        ?>
        @if(in_array('senin',$kalimat))
        <a class="btn btn-info" style="color:white;"><i class="fas fa-clock"></i> {{$v->jam_mulai}} - {{$v->jam_selesai}}</a>
        @else
        <a class="btn btn-danger" style="color:white;"><i class="fas fa-times"></i> Tidak ada jadwal hari ini</a>
        @endif

    </td>
    <td>
      @if(in_array('selasa',$kalimat))
      <a class="btn btn-info" style="color:white;"><i class="fas fa-clock"></i> {{$v->jam_mulai}} - {{$v->jam_selesai}}</a>
      @else
      <a class="btn btn-danger" style="color:white;"><i class="fas fa-times"></i> Tidak ada jadwal hari ini</a>
      @endif
    </td>
    <td>
      @if(in_array('rabu',$kalimat))
      <a class="btn btn-info" style="color:white;"><i class="fas fa-clock"></i> {{$v->jam_mulai}} - {{$v->jam_selesai}}</a>
      @else
      <a class="btn btn-danger" style="color:white;"><i class="fas fa-times"></i> Tidak ada jadwal hari ini</a>
      @endif
    </td>
    <td>
      @if(in_array('kamis',$kalimat))
      <a class="btn btn-info" style="color:white;"><i class="fas fa-clock"></i> {{$v->jam_mulai}} - {{$v->jam_selesai}}</a>
      @else
      <a class="btn btn-danger" style="color:white;"><i class="fas fa-times"></i> Tidak ada jadwal hari ini</a>
      @endif
    </td>
    <td>
      @if(in_array('jumat',$kalimat))
      <a class="btn btn-info" style="color:white;"><i class="fas fa-clock"></i> {{$v->jam_mulai}} - {{$v->jam_selesai}}</a>
      @else
      <a class="btn btn-danger" style="color:white;"><i class="fas fa-times"></i> Tidak ada jadwal hari ini</a>
      @endif
    </td>
    <td>
      @if(in_array('senin',$kalimat))
      <a class="btn btn-info" style="color:white;"><i class="fas fa-clock"></i> {{$v->jam_mulai}} - {{$v->jam_selesai}}</a>
      @else
      <a class="btn btn-danger" style="color:white;"><i class="fas fa-times"></i> Tidak ada jadwal hari ini</a>
      @endif
    </td>
    <td>
      @if(in_array('minggu',$kalimat))
      <a class="btn btn-info" style="color:white;"><i class="fas fa-clock"></i> {{$v->jam_mulai}} - {{$v->jam_selesai}}</a>
      @else
      <a class="btn btn-danger" style="color:white;"><i class="fas fa-times"></i> Tidak ada jadwal hari ini</a>
      @endif
    </td>
  </tr>

</table>
@endforeach

    </div>
  </div>
</div>
@else
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fa fa-list"></i> List Jadwal Guru</h4>
      <h6 class="card-subtitle">Data ini digunakan untuk melihat list jadwal para guru</h6>


      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th></th>
            <th>Nama</th>
            <th>Kategori Layanan</th>
            <th>Kategori Mengajar</th>
            <th>action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($data as $i=>$v)
            <?php
            $layanan = App\Gurumodel::join('jadwals','jadwals.id_guru','gurus.id_guru')
                       ->join('kategorilayanans','kategorilayanans.id_kategorilayanan','jadwals.id_kategorilayanan')
                       ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
                       ->where('gurus.id_guru',$v->id_guru)->get();
             ?>
              <tr @if($v->blokir=='Y') style="background-color:#ff001814;" @endif>
                <td style="width:5%">{{$i+1}}</td>
                <td style="width:10%"><img style="width:50px;height:50px;" class="img-profile rounded-circle" src="{{asset('guru/'.$v->image)}}"></td>
                <td style="width:10%">{{$v->nama_guru}}</td>
                <td style="width:30%">
                  @foreach($layanan as $i => $vl)
                    {{$vl->kategorilayanan}}
                  @endforeach
                </td>
                <td style="width:30%">
                  @foreach($layanan as $i => $vl)
                    {{$vl->kategorimengajar}}
                  @endforeach
                </td>


              <td style="width:30%">
                <div class="row" style="padding:20px;">
                  <a class="btn btn-info btn-sm" href="{{url('jadwalmengajar?lihat='.base64_encode($v->id_guru))}}"><i style="color:white;" class="fa fa-calendar"></i> Lihat Jadwal </a>&nbsp;

                </div>


              </td>
            </tr>

          @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif
</div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
