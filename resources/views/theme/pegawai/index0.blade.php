@extends('theme.Layouts.design')
@section('content')
<?php
use App\Cmenu;
$class = new Cmenu();
$bulan = (isset($_GET['bulan'])) ? $_GET['bulan'] : date('m');
$tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
 ?>
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


<div class="row">
<div class="col-12">
  <div class="card">
    @if(isset($_GET['lihat']))
    <?php
      $pg = (object) $class->getprofilpgapino('asal',base64_decode($_GET['lihat']));

     ?>
      @if(!empty($pg->no))
    <div class="card">
    <div class="card-body">


            <a class="btn btn-danger" style="float:right;margin-bottom:10px;" href="{{url('datapegawai')}}"><i class="fa fa-times"></i></a>

            <div class="ui top attached segment"><h5 style="font-weight:bold;"><i class="fa fa-user"></i> Data Pegawai</h5> </div>


            <table class="ui definition celled table">
                    <tbody>
                      <tr>
                        <td class="definition three wide" colspan="5" rowspan="6" width="128px">
                        <img style="height:120px;" src="{{$class->does_url_exists($pg->no)}}" class="img-circle elevation-2" alt="User Image"> </td>

                      </tr>
                    <tr>
                      <td class="definition three wide">Nama Pegawai</td>
                      <td>{{$pg->gd.$pg->nama.$pg->gb}}                                           </td>
                      <td class="definition three wide">Jabatan</td>
                      <td>{{$pg->nama_pimpinan. $pg->sub_unor}}</td>
                    </tr>
                    <tr>
                      <td class="definition three wide">NIP</td>
                      <td>{{$pg->nip_baru}}</td>
                      <td class="definition three wide">Pangkat / Gol</td>
                      <td>{{$pg->pangkat}} ({{$pg->gol}})</td>
                    </tr>
                    <tr>
                      <td class="definition three wide">NO HP</td>
                      <td>
                         {{$pg->no_hp}}
                         </td>
                      <td class="definition three wide">Instansi</td>
                      <td>
                        <span class="ui label ">{{$pg->nama_unitkerja}}</span>
                      </td>
                    </tr>


                    </tbody>
                    </table>
          </div>
    </div>
    <div class="card" style="width:100%;">
        <div class="row">
          <div class="card-body">
            <div class="ui top attached segment">
            <h5 style="font-weight:bold;margin-left:20px;"><i class="fa fa-file"></i> Rekap Absensi Pegawai Bersangkutan</h5>
              <div class="card-body">
                <select class="caribulan form-control" style="width:300px;float:right;" name="sbulan" onchange="if (this.value) window.location.href=this.value">
                  <?php
                  $now = (isset($_GET['bulan']))?$_GET['bulan']:ltrim(date('m'),'0');
                  $namaBulan = array("--Pilih Bulan--","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                  $noBulan   = 1;
                  $ki        = Session::get('id_istansi');
                  ?>
                  @for($index=0; $index<'13'; $index++)
                  <?php
                  $bln = ($index < 10)? '0'.$index:$index;
                   ?>
                      <option value="@if($bln=='00') @else {{url('datapegawai?lihat='.$_GET['lihat'].'&bulan='.$bln.'&tahun='.$tahun.'&cari=cari')}} @endif" @if($index==$now) selected @endif>{{$namaBulan[$index]}}</option>
                  @endfor
                </select>
                              <br>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Data Absensi</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Statistik Kehadiran</a>
                  </li>


                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                  <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                    <!--Realisasi SKP-->


                  <tfooter></tfooter>

                  <tfooter>
                    </tfooter><tfooter>
                    </tfooter>
                                      <table border="1px" style="width:100%">
                  <thead>
                    <tr style="background-color:#aae4aa;">
                      <th rowspan="2" style="width:50px;font-size:10pt;text-align:center" class="thclass"><b>No</b></th>
                      <th rowspan="2" style="font-size:8pt;width:200px;"><b><center>Hari , Tanggal</center></b></th>
                      <th colspan="7" style="font-size:10pt;"><b><center>KETERANGAN KEHADIRAN</center></b>
                      </th>


                    </tr>
                    <tr style="background-color:yellow;">
                      <th style="font-size:7pt;"><center>H</center></th>
                      <th style="font-size:7pt;font-weight:bold"><center>D</center></th>

                      <th style="font-size:7pt;font-weight:bold"><center>C</center></th>
                      <th style="font-size:7pt;font-weight:bold"><center>S</center></th>
                      <th style="font-size:7pt;font-weight:bold"><center>A</center></th>
                      <th style="font-size:7pt;font-weight:bold"><center>P</center></th>


                    </tr>
                    <tr class="thatas" style="text-align: center;background-color:#bfc12221;">
                     <td style="font-size:5pt">1</td>
                     <td style="font-size:5pt">2</td>
                     <td style="font-size:5pt">3</td>

                     <td style="font-size:5pt">5</td>
                     <td style="font-size:5pt">6</td>
                     <td style="font-size:5pt">7</td>
                     <td style="font-size:5pt">8</td>
                     <td style="font-size:5pt">9</td>


                   </tr>
                   <?php
                      $awaltgl =  new DateTime(date($tahun.'-'.$bulan.'-01'));
                      $akhir   = new DateTime(date($tahun.'-'.$bulan.'-t'));
                      $index = 0;
                      for($i = $awaltgl; $i <= $akhir; $i->modify('+1 day')){
                      $index++;
                      $tgl        = $class->tgl_indo($i->format("Y-m-d"))['tgl'];
                      $tglindex   = $class->tgl_indo($i->format("Y-m-d"))['tglindex'];
                      $absen = $class->recordabsen(base64_decode($_GET['lihat']),$tglindex);
                      $A     = ($absen == null AND date('Y-m-d') > $tglindex ) ? 'A':'-';
                      $H     = ($absen != null AND $absen->status == 'H') ? 'H':'-';
                      $D     = ($absen != null AND $absen->status == 'D') ? 'D':'-';

                      $C     = ($absen != null AND $absen->status == 'C') ? 'C':'-';
                      $S     = ($absen != null AND $absen->status == 'S') ? 'S':'-';
                    ?>

                    <tr style="background-color:{{$class->tgl_indo($i->format("Y-m-d"))['color']}}">
                      <td style="text-align:center">{{$index}}</td>
                      <td>{{$tgl}}</td>
                      <td style="text-align:center">{{$H}}</td>
                      <td style="text-align:center">{{$D}}</td>

                      <td style="text-align:center">{{$C}}</td>
                      <td style="text-align:center">{{$S}}</td>
                      <td style="text-align:center">{{$A}}</td>
                      <td></td>

                    </tr>
    <?php
}
?>

                                      </thead>
                   </table>
                                <!---/Realisasi SKP-->



                  </div>
                  <!--Lembar Penilaian-->
                  <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                    <div class="card">
                    <!-- Info boxes -->

                    <div class="row">
                      <div class="card-body">
                        <table class="table table-hover table-bordered">
                          <thead>
                            <tr style="background-color:#aae4aa;">
                              <th style="width:10px;">No</th>
                              <th colspan="2">KRITERIA INDIKATOR</th>
                              <th colspan="4">PERSENTASE PENILAIAN TPP</th>
                            </tr>
                          </thead>
                                                      <tbody><tr>
                              <td colspan="7" style="text-align:center;background-color:#ff000014">Belum Ada Realisasi</td>
                            </tr>

                        </tbody></table>


                        </div>
                    </div>

                  </div>
                  </div>
                  <!--/Lembar Penilaian-->

                  <!--Catatan Penilaian-->
                  <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                    <div class="card">
                    <!-- Info boxes -->
                    <div class="row">
                      <div class="card-body">

                        <table class="table table-hover table-bordered">
                          <thead>
                            <tr style="background-color:#aae4aa;">
                              <th style="width:10px;text-align:center">No</th>
                              <th style="text-align:center;">Tanggal</th>
                              <th style="text-align:center" colspan="2">Uraian</th>
                              <th style="text-align:center">Nama/ NIP dan Paraf Pejabat Penilai</th>
                            </tr>
                          </thead>
                                                    <tbody><tr>
                            <td colspan="7" style="text-align:center;background-color:#ff000014">Belum Ada Realisasi</td>
                          </tr>

                        </tbody></table>



                      </div>
                    </div>
                  </div>
                </div>
                  <!--/Lembar Penilaian-->
              </div>
                </div>

              </div>




          </div>
        </div>
      </div>

      @else
      @include('theme.error.404')

      @endif

    @else
    <div class="card">
    <div class="card-body">
    <h4 class="card-title">Data Pegawai</h4>

      <h6 class="card-subtitle"></h6>

      <br>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
            <th>No</th>
            <th></th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Agama</th>
            <th>Pangkat</th>
            <th>Gol</th>
            <th>Alamat</th>
            <th width="10%"></th>
        </thead>
        <tbody>
          @foreach($data as $key=>$row)
          <tr>
            <td><small>{{$key+1}}</small></td>
            <td><img style="height:50px;" src="{{$class->does_url_exists($row['no'])}}" class="img-circle elevation-2" alt="User Image"></td>

            <td><small>{{$row['nama']}}<br />NIP : {{$row['nip_baru']}}
            </small></td>
            <td> <small>{{$row['nama_pimpinan'].$row['sub_unor']}}</small></td>
            <td><small>{{$row['agama']}}</small></td>
            <td><small>{{$row['pangkat']}}</small></td>
            <td><small>{{$row['gol']}}</small></td>
            <td><small>{{$row['alamat_peg']}}</small></td>
            <td>
              <button onclick="reset({{$row['no']}})"  class="btn btn-warning btn-sm"> <i style="color:white" class="fa fa-lock"></i></button>
              <a href="{{url('datapegawai?lihat='.base64_encode($row['no']))}}" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
            </td>
          </tr>
          <script>
           function reset(id){
               swal({   title: "Anda yakin ingin mereset Password akun ini ???", text: "Password yang direset default NIP Pegawai",
                       type: "warning",
                       showCancelButton: true,
                       confirmButtonColor: "#b8172d",
                       confirmButtonText: "Ya, Reset!",
                       closeOnConfirm: false },
             function(){ swal("data berhasil dihapus!", "", "success")
                   window.location = '{{url("/pegawai/hapusformulir")}}/'+id;
                 });


               }
             </script>

          @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>
    @endif

  </div>
</div>
</div>



</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
