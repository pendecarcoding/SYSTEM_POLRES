<?php
use App\Cmenu;
$class = new Cmenu();
?>
@extends('theme.Layouts.design')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-list"></i> Daftar Usulan Cuti Pegawai</h1>
                <p></p>
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
                        <input id="tgl" style="width:20%;float:right;margin-right:2px;" type="date" name="tgl"
                            class="form-control" value="2023-08-01">
                        <select id="skpd" class="form-control" style="width:20%;float:right;margin-right:2px;"
                            name="jenis">
                            @foreach ($skpd as $i => $v)
                                <option value="{{$v->kode_unitkerja}}">{{ $v->nama_unitkerja }}</option>
                            @endforeach
                        </select>
                        <h4 class="card-title">Daftar Usulan Cuti Pegawai</h4>

                    </div>
                    <div class="card-body">


                        <h6 class="card-subtitle"></h6>

                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="tableabsen">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jenis Cuti</th>
                                        <th>Lama Cuti</th>
                                        <th>Tgl Pengajuan</th>
                                        <th>Status</th>
                                        <th>File</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        </div>


    </main>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
 $(document).ready(function () {
    var tgl   = document.getElementById('tgl').value;
    var skpd  = document.getElementById('skpd').value;
      $('#tableabsen').DataTable({
          processing: true,
          retrieve: true,
          serverSide: true,
          ajax: "{{ url('apiusulancuti') }}?skpd="+skpd+"&tanggal="+tgl,
          columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_cuti',
                        name: 'jeniscuti'
                    },
                    {
                        data: 'lama_cuti',
                        name: 'lamacuti'
                    },
                    {
                        data: 'tgl_pengajuan',
                        name: 'tglpengajuan'
                    },{
                        data: 'status',
                        name: 'status'
                    },{
                        data: 'file',
                        name: 'file'
                    },{
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
      });
  });
  $('#tgl').change(function(){
    var skpd = document.getElementById('skpd').value;
    var tgl   = $(this).val();
    var table = document.getElementById('tableabsen');
		$('#tableabsen').DataTable({
          destroy: true,
          processing: true,
          serverSide: true,
          ajax: "{{ url('apiusulancuti') }}?skpd="+skpd+"&tanggal="+tgl,
          columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_cuti',
                        name: 'jeniscuti'
                    },
                    {
                        data: 'lama_cuti',
                        name: 'lamacuti'
                    },
                    {
                        data: 'tgl_pengajuan',
                        name: 'tglpengajuan'
                    },{
                        data: 'status',
                        name: 'status'
                    },{
                        data: 'file',
                        name: 'file'
                    },{
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
      });
  });

  $('#skpd').change(function(){
    var skpd = document.getElementById('skpd').value;
    var tgl   = document.getElementById('tgl').value;
    var table = document.getElementById('tableabsen');
		$('#tableabsen').DataTable({
          destroy: true,
          processing: true,
          serverSide: true,
          ajax: "{{ url('apiusulancuti') }}?skpd="+skpd+"&tanggal="+tgl,
          columns: [{ // mengambil & menampilkan kolom sesuai tabel database
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_cuti',
                        name: 'jeniscuti'
                    },
                    {
                        data: 'lama_cuti',
                        name: 'lamacuti'
                    },
                    {
                        data: 'tgl_pengajuan',
                        name: 'tglpengajuan'
                    },{
                        data: 'status',
                        name: 'status'
                    },{
                        data: 'file',
                        name: 'file'
                    },{
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
      });
  });
  </script>
@endsection
