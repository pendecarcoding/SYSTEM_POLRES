@extends('theme.Layouts.design')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Users</h1>
      <p>Untuk mengatur user Aplikasi</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Data Users</h4>
      <h6 class="card-subtitle">Data ini digunakan untuk menambahkan data users</h6>
      <a data-toggle="modal" data-target="#tambah" style="color:white;"class="btn waves-effect waves-light btn-primary">Tambah Data</a>
      <!-- Modal -->
      <div class="modal fade" id="tambah" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
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
              <label>Unit Kerja</label><br>
              <select style="width:100%" class="form-control select2" name="unitkerja" required>
                <option value="">--Pilih Unit Kerja--</option>

                 @foreach($listintansi as $index=>$v)
                   @if($v['nama_unitkerja'] !='')
                   <option value="{{$v['kode_unitkerja']}}">{{$v['nama_unitkerja']}}</option>
                   @endif
                 @endforeach

              </select><br>
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
        <table class="table table-hover table-bordered" id="sampleTable">
        <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Level</th>
          <th>action</th>
        </tr>
        </thead>
        <tbody>
          @foreach($data as $i=>$v)
            <tr>
              <td style="width:5%">{{$i+1}}</td>
              <td style="width:50%">{{$v->nama}}</td>
              <td style="width:20%">{{$v->username}}</td>
              <td style="width:80%">{{$v->level}}</td>

              <td>
                <span data-toggle="tooltip" data-placement="top" title="Aksi Untuk Edit">
                                      <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#m{{$v->id_user}}"><i style="color:white;" class="fas fa-pencil-alt"></i> </a>&nbsp;
                                    </span>
                                      <a  data-toggle="tooltip" data-placement="top" title="Aksi Untuk Hapus" onclick="return confirm('Hapus?')" href="{{url('users/hapus/'.base64_encode($v->id_user))}}" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>

              </td>
            </tr>
            <div class="modal fade" id="m{{$v->id_user}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Update Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                  </div>
                  <form action="{{url('users/update')}}" method="post">{{csrf_field()}}
                    <div class="modal-body">
                      <label>Nama</label>
                      <input type="hidden" class="form-control" name="id" value="{{$v->id_user}}" required placeholder="nama">
                      <input type="text" value="{{$v->nama}}" class="form-control" name="nama" required placeholder="nama">
                      <label>Username</label>
                      <input type="text" class="form-control" value="{{$v->username}}" name="username" required placeholder="username">
                      <label>Level</label>
                      <select class="form-control" name="level" required>
                        <option value="">--Pilih Level--</option>
                        <?php
                          $level = App\level::where('level','!=','admin')->get();
                         ?>
                         @foreach($level as $index=>$s)
                           <option value="{{$s->level}}" @if($v->level==$s->level) selected @endif>{{$s->level}}</option>
                         @endforeach

                      </select>
                      <label>Unit Kerja</label><br>
                      <select style="width:100%" class="form-control select2" name="unitkerja" required>
                        <option value="">--Pilih Unit Kerja--</option>

                         @foreach($listintansi as $index=>$u)
                           @if($u['nama_unitkerja'] !='')
                           <option value="{{$u['kode_unitkerja']}}" @if($u['kode_unitkerja']==$v->kode_unitkerja) selected @endif>{{$u['nama_unitkerja']}}</option>
                           @endif
                         @endforeach

                      </select><br>
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
          @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
