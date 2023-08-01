@extends('theme.Layouts.design')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Level User</h1>
      <p>Untuk mengatur Level User Aplikasi</p>
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
      <h4 class="card-title">level Level</h4>
      <h6 class="card-subtitle">Data ini digunakan untuk menambahkan level user</h6>
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
            <form action="{{url('level/add')}}" method="post">{{csrf_field()}}
            <div class="modal-body">
              <label>Level</label>
              <input type="text" class="form-control" name="level" required>

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
          <th>Level</th>
          <th>action</th>
        </tr>
        </thead>
        <tbody>
          @foreach($data as $i=>$v)
            <tr>
              <td style="width:5%">{{$i+1}}</td>
              <td style="width:80%">{{$v->level}}</td>

              <td>
                <span data-toggle="tooltip" data-placement="top" title="Aksi Untuk Edit">
                                      <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#m{{$v->id_level}}"><i style="color:white;" class="fas fa-pencil-alt"></i> </a>&nbsp;
                                    </span>
                                      <a  data-toggle="tooltip" data-placement="top" title="Aksi Untuk Hapus" onclick="return confirm('Hapus?')" href="{{url('level/hapus/'.base64_encode($v->id_level))}}" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>

              </td>
            </tr>
            <div class="modal fade" id="m{{$v->id_level}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Update Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                  </div>
                  <form action="{{url('level/update')}}" method="post">{{csrf_field()}}
                  <div class="modal-body">
                    <label>Level</label>
                    <input type="hidden" value="{{$v->id_level}}" class="form-control" name="id" required>
                    <input type="text" value="{{$v->level}}" class="form-control" name="level" required>

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
