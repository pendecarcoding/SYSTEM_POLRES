@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
use App\Penempatan;
use App\Bidang;
use App\Aktor;
use App\AlurDispo;
use App\Cmenu;
$level = Level::all();
 ?>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Data Penempatan</h1>
      <p>Menu untuk mengatur Data Bidang</p>
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
          <h4 class="card-title">Daftar Penempatan Pegawai
          </h4>
        </div>
        <div class="card-body">
          <div class="row" style="padding:10px;">
            @foreach($data as $index => $v)
              <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-folder fa-3x"></i>
                  <div class="info">
                    <h6>{{ $v->bidang }}</h6>
                    <a href="{{ url('penempatan_jabatan?lihatpegawai='.base64_encode($v->id_bidang)) }}"
                      class="btn btn-outline-secondary" style="color:black;margin-bottom:10px;"><b>Lihat Pegawai</b></a>
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>
      </div>
      <div class="card">
        @if(isset($_GET['lihatpegawai']))
          <?php
    $bidang = Bidang::where('id_bidang',base64_decode($_GET['lihatpegawai']))->first();
    ?>
          <div class="modal fade" id="tambah" role="dialog">
            <div class="modal-dialog modal-md">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="border-color:gren ">
                  <h4 class="modal-title">Tambah Pegawai {{ $bidang->bidang }}</h4>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>


                </div>
                <form action="{{ url('addpenempatan') }}" method="POST">{{ csrf_field() }}
                <div class="modal-body">
                    
                     <label>Pilih Data Pegawai</label>
                    <select class="form-control" name="pegawai" >
                      @foreach($pegawai as $ip => $vp)
                      <option value="{{ $vp->id }}">{{ '('.$vp->nip.')'.$vp->gd.' '.$vp->nama.' '.$vp->gb }}</option>
                      @endforeach

                    </select>
                    <input type="hidden" name="id_bidang" value="{{ $bidang->id_bidang }}">
                    <label>Jabatan Pegawai</label>
                    <select class="form-control" name="jabatan" required >
                      @foreach($jabatan as $ij => $vj)
                      <option value="{{ $vj->jabatan }}">{{ $vj->jabatan }}</option>
                      @endforeach

                    </select>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-primary"> <i class="fa fa-save"></i> Simpan</button>
                </div>
                </form>
              </div>
            </div>
          </div>
          <div class="card-header">
            <a data-toggle='modal' href="#tambah" data-target="#tambah" style="color:white;"
              class="btn waves-effect waves-light btn-primary pull-right"><i class="fa fa-plus"></i> Tambah ASN</a>
            <h4>Daftar Pegawai {{ $bidang->bidang }}</h4>

          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Pegawai</th>
                    <th>Jabatan</th>
                    <th>Bidang</th>
                    
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($penempatan as $ip => $vp)
                  <tr>
                    <td>{{ $ip+1 }}</td>
                    <td>{{ $vp->gd.' '.$vp->nama.' '.$vp->gb }}</td>
                    <td>{{ $vp->jabatan }}</td>
                    <td>{{ $bidang->bidang }}</td>
                    <td>
                      <a data-toggle='modal' href="#" data-target="#edit{{ $vp->id }}">
                        <i class="fa fa-edit text-warning" aria-hidden=""></i> </a> &nbsp;&nbsp;
                      <a onclick="return confirm('Yakin untuk menghapus?')"
                        href="{{ url('hapuspenempatan/'.base64_encode($vp->id)) }}">
                        <i class="fa fa-trash text-danger" aria-hidden=""></i>
                      </a>
                    </td>
                  </tr>
                  @include('theme.bidang.modalpenempatan')
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
  @endif


  <!-- ============================================================== -->
  <!-- End Container fluid  -->
  @endsection