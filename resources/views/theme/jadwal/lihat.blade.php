@extends('theme.Layouts.design')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <a href="{{url('daftarajuan')}}" class="btn btn-danger" style="float:right;color:white;"><i class="fa fa-times"></i></a>
      <h4 class="card-title">Kwitansi Pembayaran</h4>

      <h6 class="card-subtitle">Kwitansi Ini dinyatakan Sebagai Bukti Pembayaran yang telah dilakukan dari Pihak terkait kepada Admin Gedung Cikpuan </h6>
      <h6 class="card-subtitle" style="font-weight:bold;">Berikut Rincian Data Pembayaran :</h6>
      <hr>
      <table>
        <tr>
          <td>Nama Penyewa</td>
          <td>:</td>
          <td> {{$data->nama}}</td>
        </tr>
        <tr>
          <td>Perihal Peminjaman</td>
          <td>:</td>
          <td> {{$data->kebutuhan}}</td>
        </tr>
        <tr>
          <td>Lama Sewa</td>
          <td>:</td>
          <td>{{$data->lama}} Hari</td>
        </tr>
        <tr>
          <td>Tgl Pengajuan, Jam</td>
          <td>:</td>
          <td>{{$data->tgl_permintaan}}, {{$data->jam}}</td>
        </tr>
        <tr>
          <td>Tagihan</td>
          <td>:</td>
          <td>Rp {{number_format($data->tagihan)}}</td>
        </tr>
        <tr>
          <td>Dibayarkan</td>
          <td>:</td>
          <td>Rp {{number_format($data->dibayar)}}</td>
        </tr>
        <tr>
          <td>Status Pembayaran</td>
          <td>:</td>
          <td>{{$data->status}}</td>
        </tr>
        <tr>
          <td>Status Konfirmasi</td>
          <td>:</td>
          <td>@if($data->konfirmasi=='Y') Valid @endif @if($data->konfirmasi=='T') Tidak Valid @endif</td>
        </tr>
      </table>
      <div style="float:right;margin-right:100px;">
      <h4>Mengetahui</h4>
      <hr>
      <br>
      Admin Aplikasi
    </div>

    </div>
    <div class="card-footer">
        <a style="float:right;color:white" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
    </div>
  </div>
</div>
</div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
