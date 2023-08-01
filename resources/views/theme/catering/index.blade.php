@extends('theme.Layouts.design')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fa fa-users"></i> Data Pemilik Catering
      <h6 class="card-subtitle">Data ini digunakan untuk menajemen data pemilik Catering</h6>


      <div class="modal fade" id="tambah" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">

            <form action="{{url('users/add')}}" method="post">{{csrf_field()}}
            <div class="modal-body">
              <label>Nama</label>
              <input type="text" class="form-control" name="nama" required placeholder="nama">
              <label>Username</label>
              <input type="text" class="form-control" name="username" required placeholder="username">
              <label>Level</label>
              <select class="form-control" name="level" required>
                <option value="">--Pilih Level--</option>
                <?php
                  $level = App\Level::where('level','!=','admin')->get();
                 ?>
                 @foreach($level as $index=>$v)
                   <option value="{{$v->level}}">{{$v->level}}</option>
                 @endforeach

              </select>
              <label>Password</label>
              <input type="password" class="form-control" name="pass" required placeholder="password">
             </div>
            <div class="modal-footer">
              <a style="color:white;" class="btn btn-default" data-dismiss="modal">Close</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
          </div>
        </div>
      </div>
      <br>
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
            @foreach($data as $i=>$v)
              <tr>
                <td>{{$i+1}}</td>
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
            <div class="modal fade" id="m{{$v->id_guru}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">{{$v->nama_guru}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                  </div>

                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-3">
                            <img style="width:100%;height:200px;" class="img-profile rounded-circle" src="{{asset('guru/'.$v->image)}}">
                        </div>
                        <div class="col-md-9">
                          <label>Nama Guru</label>
                          <input type="hidden" class="form-control" name="id" value="{{$v->id_user}}" required placeholder="nama">
                          <input type="text" disabled value="{{$v->nama_guru}}" class="form-control" name="nama" required placeholder="nama">
                          <label>No Hp</label>
                          <input type="text" disabled class="form-control" value="{{$v->no_hp}}" name="username" required placeholder="username">
                          <label>Email</label>
                          <input type="text" disabled class="form-control" value="{{$v->email}}" name="username" required placeholder="username">
                          <label>Jenis Kelamin</label>
                          <input type="text" disabled class="form-control" value="{{$v->jenis_kelamin}}" name="pass" required placeholder="password">
                          <label>Alamat</label>
                          <input type="text" disabled class="form-control" value="{{$v->alamat}}" name="pass" required placeholder="password">

                        </div>
                      </div>


                     </div>


                </div>
              </div>
            </div>
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
