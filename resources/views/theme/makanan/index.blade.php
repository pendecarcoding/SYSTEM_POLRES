@extends('theme.Layouts.design')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fa fa-database"></i> Data Menu Makanan
        <a data-toggle="modal" data-target="#tambah" class="btn btn-primary"style="color:white;float:right"><i class="fa fa-plus"></i> Tambah Data</a></h4>
      <h6 class="card-subtitle">Data ini digunakan untuk menajemen data Menu Makanan</h6>


      <div class="modal fade" id="tambah" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">

            <form action="{{url('addmenumakanan')}}" method="post">{{csrf_field()}}
              <div class="modal-header">
                <h3>Tambah Menu Makanan</h4>
              </div>
            <div class="modal-body">
              <label>Nama Menu Makanan</label>
              <input type="text" class="form-control" name="menumakanan" required placeholder="Nama Menu Makanan">

            <div class="modal-footer">
              <a style="color:white;" class="btn btn-default" data-dismiss="modal">Close</a>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"> </i>Simpan</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th style="width:5%">#</th>
            <th style="width:85%">Menu Makanan</th>
            <th>action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($data as $index =>$v)
            <tr>
              <td>{{$index+1}}</td>
              <td>{{$v->menumakanan}}</td>
              <td>
                <a style="color:white;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#m{{$v->id_menumakanan}}"><i style="color:white;" class="fa fa-edit"></i></a>&nbsp;
                <a data-toggle="tooltip" data-placement="top" title="Aksi Untuk Hapus Data" onclick="return confirm('Anda yakin akan menghapus data ini?, data yang dihapus tidak dapat dikembalikan')" href="{{url('hapusmenumakanan/'.base64_encode($v->id_menumakanan))}}" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>

              </td>
            </tr>
            <div class="modal fade" id="m{{$v->id_menumakanan}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">

                  <form action="{{url('updatemenumakanan')}}" method="post">{{csrf_field()}}
                    <div class="modal-header">
                      <h3>Update Menu Makanan</h4>
                    </div>
                  <div class="modal-body">
                    <label>Nama Menu Makanan</label>
                    <input type="hidden" name="id" value="{{$v->id_menumakanan}}">
                    <input type="text" class="form-control" value="{{$v->menumakanan}}" name="menumakanan" required placeholder="Nama Menu Makanan">

                  <div class="modal-footer">
                    <a style="color:white;" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"> </i>Simpan</button>
                  </div>
                </form>
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
