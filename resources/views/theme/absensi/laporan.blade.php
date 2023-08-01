@extends('theme.Layouts.design')
@section('content')
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
                <form action="https://absensi.bengkaliskab.go.id/ajukanizin" method="post" enctype="multipart/form-data"><input type="hidden" name="_token" value="LycNBsiOolN9FpfxaykNXvLOHUNKRRxzmR4PJl89">
                <div class="modal-body">
                  <input type="hidden" name="jenis" value="C">
                  <input type="hidden" name="kat" value="A">
                  <label>No SURAT</label>
                  <input type="text" class="form-control" name="nosurat" value="">
                  <label>Pegawai</label>
                  <select class="form-control select2" name="pg[]" id="exampleSelect2" multiple=""
                          style="width: 100%;color:white;">
                                    <option value="" >-ZulkifliST</option>
                                    <option value="" >-Hendrik Dwi Yatmoko,S.Sos</option>
                                    <option value="" >-Bohati MulyadiSE</option>
                                    <option value="" >-AzmarS.Kom</option>
                                    <option value="" >-Mohd. ElkhusairiST</option>
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
                <form action="https://absensi.bengkaliskab.go.id/ajukanizin" method="post" enctype="multipart/form-data"><input type="hidden" name="_token" value="LycNBsiOolN9FpfxaykNXvLOHUNKRRxzmR4PJl89">
                <div class="modal-body">
                  <input type="hidden" name="jenis" value="S">
                  <input type="hidden" name="kat" value="A">
                  <label>No Surat</label>
                  <input type="text" class="form-control" name="nosurat" value="">
                  <label>Pegawai</label>
                  <select class="form-control select2" name="pg[]" id="exampleSelect2" multiple=""
                          style="width: 100%;color:white;">
                                    <option value="" >-ZulkifliST</option>
                                    <option value="" >-Hendrik Dwi Yatmoko,S.Sos</option>
                                    <option value="" >-Bohati MulyadiSE</option>
                                    <option value="" >-AzmarS.Kom</option>
                                    <option value="" >-Mohd. ElkhusairiST</option>
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
                <form action="https://absensi.bengkaliskab.go.id/ajukanizin" method="post" enctype="multipart/form-data"><input type="hidden" name="_token" value="LycNBsiOolN9FpfxaykNXvLOHUNKRRxzmR4PJl89">
                <div class="modal-body">
                  <input type="hidden" name="jenis" value="D">
                  <input type="hidden" name="kat" value="A">
                  <label>No SPT</label>
                  <input type="text" class="form-control" name="nosurat" value="">
                  <label>Pegawai</label>
                  <select class="form-control select2" name="pg[]" id="exampleSelect2" multiple=""
                          style="width: 100%;color:white;">
                                    <option value="" >-ZulkifliST</option>
                                    <option value="" >-Hendrik Dwi Yatmoko,S.Sos</option>
                                    <option value="" >-Bohati MulyadiSE</option>
                                    <option value="" >-AzmarS.Kom</option>
                                    <option value="" >-Mohd. ElkhusairiST</option>
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
                        <a style="float:right;color:white" class="btn btn-primary"><i class="fa fa-print"></i> Cetak
                            data</a>
                          
                        <select id="jenisabsen" class="form-control" style="width:20%;float:right;margin-right:2px;"
                            name="jenis">
                            <option>--Jenis Absensi--</option>
                            <option value="M">Masuk</option>
                            <option value="P">Pulang</option>
                        </select>
                        <input id="tgl" style="width:20%;float:right;margin-right:2px;" type="date"
                            name="tgl" class="form-control" value="2023-08-01">
                            <select id="jenisabsen" class="form-control" style="width:20%;float:right;margin-right:2px;"
                            name="jenis">
                            <option>--Pilih SKPD--</option>
                            @foreach($skpd as $i =>$v)
                            <option value="M">{{$v->nama_unitkerja}}</option>
                            @endforeach
                        </select>
                        <h4 class="card-title"><i class="fa fa-calendar"></i> Data Absensi</h4>


                        <h6 class="card-subtitle">
                            Data absensi ini di record berdasarkan record pegawai yang melakukan absensi
                        </h6>

                    </div>
                    <div class="card-body">

                        <br>
                        <div class="table-responsive">
                            <div id="tableabsen_wrapper"
                                class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="tableabsen_length"><label>Show <select
                                                    name="tableabsen_length" aria-controls="tableabsen"
                                                    class="form-control form-control-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> entries</label></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="tableabsen_filter" class="dataTables_filter"><label>Search:<input
                                                    type="search" class="form-control form-control-sm" placeholder=""
                                                    aria-controls="tableabsen"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-hover table-bordered dataTable no-footer"
                                            id="tableabsen" role="grid" aria-describedby="tableabsen_info"
                                            style="width: 1224px;">
                                            <thead>
                                                <tr role="row">
                                                    <th rowspan="2" style="text-align: center; width: 32.2px;"
                                                        class="sorting_asc" tabindex="0" aria-controls="tableabsen"
                                                        colspan="1" aria-sort="ascending"
                                                        aria-label="No: activate to sort column descending">No</th>
                                                    <th rowspan="2" style="text-align: center; width: 195.2px;"
                                                        class="sorting" tabindex="0" aria-controls="tableabsen"
                                                        colspan="1"
                                                        aria-label="Nama: activate to sort column ascending">Nama</th>
                                                    <th rowspan="2" style="text-align: center; width: 106.2px;"
                                                        class="sorting" tabindex="0" aria-controls="tableabsen"
                                                        colspan="1"
                                                        aria-label="Pangkat/Gol: activate to sort column ascending">
                                                        Pangkat/Gol</th>
                                                    <th rowspan="2" style="text-align: center; width: 114.2px;"
                                                        class="sorting" tabindex="0" aria-controls="tableabsen"
                                                        colspan="1"
                                                        aria-label="Waktu Absen: activate to sort column ascending">Waktu
                                                        Absen</th>
                                                    <th rowspan="2" style="text-align: center; width: 76.2px;"
                                                        class="sorting" tabindex="0" aria-controls="tableabsen"
                                                        colspan="1"
                                                        aria-label="kordinat: activate to sort column ascending">kordinat
                                                    </th>
                                                    <th rowspan="2" style="text-align: center; width: 26.2px;"
                                                        class="sorting" tabindex="0" aria-controls="tableabsen"
                                                        colspan="1" aria-label="IP: activate to sort column ascending">
                                                        IP</th>
                                                    <th colspan="8" style="text-align:center" rowspan="1">
                                                        Keterangan</th>
                                                </tr>
                                                <tr role="row">
                                                    <th style="text-align: center; width: 23.2px;" class="sorting"
                                                        tabindex="0" aria-controls="tableabsen" rowspan="1"
                                                        colspan="1" aria-label="H: activate to sort column ascending">H
                                                    </th>
                                                    <th style="text-align: center; width: 22.2px;" class="sorting"
                                                        tabindex="0" aria-controls="tableabsen" rowspan="1"
                                                        colspan="1" aria-label="D: activate to sort column ascending">D
                                                    </th>
                                                    <th style="text-align: center; width: 21.2px;" class="sorting"
                                                        tabindex="0" aria-controls="tableabsen" rowspan="1"
                                                        colspan="1" aria-label="C: activate to sort column ascending">C
                                                    </th>
                                                    <th style="text-align: center; width: 19.2px;" class="sorting"
                                                        tabindex="0" aria-controls="tableabsen" rowspan="1"
                                                        colspan="1" aria-label="S: activate to sort column ascending">S
                                                    </th>
                                                    <th style="text-align: center; width: 22.2px;" class="sorting"
                                                        tabindex="0" aria-controls="tableabsen" rowspan="1"
                                                        colspan="1" aria-label="A: activate to sort column ascending">A
                                                    </th>
                                                    <th style="text-align: center; width: 20.2px;" class="sorting"
                                                        tabindex="0" aria-controls="tableabsen" rowspan="1"
                                                        colspan="1" aria-label="P: activate to sort column ascending">P
                                                    </th>
                                                    <th style="text-align: center; width: 41px;" class="sorting"
                                                        tabindex="0" aria-controls="tableabsen" rowspan="1"
                                                        colspan="1"
                                                        aria-label="aksi: activate to sort column ascending">aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr role="row" class="odd">
                                                    <td class="sorting_1">1</td>
                                                    <td>Zulkifli ST</td>
                                                    <td></td>
                                                    <td>Belum Absen</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><img style="width:30px"
                                                            src="https://absensi.bengkaliskab.go.id/load.gif"></td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">2</td>
                                                    <td>Hendrik Dwi Yatmoko, S.Sos</td>
                                                    <td></td>
                                                    <td>Belum Absen</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><img style="width:30px"
                                                            src="https://absensi.bengkaliskab.go.id/load.gif"></td>
                                                </tr>
                                                <tr role="row" class="odd">
                                                    <td class="sorting_1">3</td>
                                                    <td>Bohati Mulyadi SE</td>
                                                    <td></td>
                                                    <td>Belum Absen</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><img style="width:30px"
                                                            src="https://absensi.bengkaliskab.go.id/load.gif"></td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">4</td>
                                                    <td>Azmar S.Kom</td>
                                                    <td></td>
                                                    <td>Belum Absen</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><img style="width:30px"
                                                            src="https://absensi.bengkaliskab.go.id/load.gif"></td>
                                                </tr>
                                                <tr role="row" class="odd">
                                                    <td class="sorting_1">5</td>
                                                    <td>Mohd. Elkhusairi ST</td>
                                                    <td></td>
                                                    <td>Belum Absen</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td><img style="width:30px"
                                                            src="https://absensi.bengkaliskab.go.id/load.gif"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div id="tableabsen_processing" class="dataTables_processing card"
                                            style="display: none;">Processing...</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="tableabsen_info" role="status"
                                            aria-live="polite">Showing 1 to 5 of 5 entries</div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="tableabsen_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled"
                                                    id="tableabsen_previous"><a href="#" aria-controls="tableabsen"
                                                        data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                                </li>
                                                <li class="paginate_button page-item active"><a href="#"
                                                        aria-controls="tableabsen" data-dt-idx="1" tabindex="0"
                                                        class="page-link">1</a></li>
                                                <li class="paginate_button page-item next disabled" id="tableabsen_next">
                                                    <a href="#" aria-controls="tableabsen" data-dt-idx="2"
                                                        tabindex="0" class="page-link">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </main>
@endsection
