@extends('theme.Layouts.design')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fa fa-users"></i> Data Konsumen
        </h4>
      <h6 class="card-subtitle">Data ini digunakan untuk menajemen data Konsumen</h6>



      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
          <th>#</th>
          <th></th>
          <th>Nama</th>
          <th>Jenis Kelamin</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Alamat</th>
          <th>Status</th>
          <th>action</th>
        </tr>
        </thead>
        <tbody>
          @foreach($data as $index => $v)
          <tr>
            <td>{{$index+1}}</td>
            <td><img style="width:50px;height:50px;" class="img-profile rounded-circle" src="{{asset('theme/users/'.$v->foto)}}"></td>
            <td>{{$v->nama}}</td>
            <td>{{$v->jk}}</td>
            <td>{{$v->email}}</td>
            <td>{{$v->nohp}}</td>
            <td>{{$v->alamat}}</td>
            <td>@if($v->blokir=='N') Aktif  @endif  @if($v->blokir=='Y') DibLokir @endif</td>

          <td style="width:15%">
            @if($v->blokir=='N') <a onclick="return confirm('Anda yakin akan memblokir Akun ini ?? Akun yang diblokir semua yang berkaitan di aplikasi tidak akan ditampilkan !!!')" href="{{url('userblokir/'.base64_encode($v->id_user))}}" style="color:white;"class="btn btn-danger btn-sm"><i class="fa fa-ban"></i></a>@endif
            @if($v->blokir=='Y')<a onclick="return confirm('Anda yakin akan membuka blokir Akun ini ?? Akun ini akan aktif kembali')" href="{{url('bukablokir/'.base64_encode($v->id_user))}}" style="color:white;"class="btn btn-primary btn-sm"><i class="fa fa-unlock"></i></a> @endif

            <a onclick="return confirm('Hapus?')" href="{{url('users/hapus/'.base64_encode($v->id_user))}}" style="color:white;"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>


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
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
