@extends('theme.Layouts.design')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fa fa-tag"></i> Data Kategori Layanan <a data-toggle="modal" data-target="#tambah" class="btn btn-primary"style="color:white;float:right;"><i class="fa fa-plus"></i> Tambah Data</a></h4>
      <h6 class="card-subtitle">Data ini berupa list Kategori Layanan</h6>
      <!--<a class="btn btn-primary"style="color:white;"><i class="fa fa-print"></i> Cetak Data</a>-->

      <div class="modal fade" id="tambah" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">

            <form action="{{url('layanan/add')}}" method="post">{{csrf_field()}}
            <div class="modal-body">
              <label>Kategorin Layanan</label>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <input type="text" class="form-control" name="layanan" required placeholder="Kategori Layanan">

             </div>
            <div class="modal-footer">

              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
            <th>Kategori Layanan</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
            @foreach($data as $i=>$v)
              <tr>
                <td style="width:5%">{{$i+1}}</td>
                <td style="width:70%">{{$v->kategorilayanan}}</td>
                <td style="width:30%">
                <div class="row" style="padding:20px;">
                  <a style="color:white;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#m{{$v->id_kategorilayanan}}"><i style="color:white;" class="fa fa-eye"></i> Lihat </a>&nbsp;
                  <a data-toggle="tooltip" data-placement="top" title="Aksi Untuk Hapus Data" onclick="return confirm('Anda yakin akan menghapus data ini?, data yang dihapus tidak dapat dikembalikan')" href="{{url('layanan/hapus/'.base64_encode($v->id_kategorilayanan))}}" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> Hapus </a>
                </div>


              </td>
            </tr>
            <div class="modal fade" id="m{{$v->id_kategorilayanan}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">

                  <form action="{{url('layanan/update')}}" method="post">{{csrf_field()}}
                  <div class="modal-body">
                    <label>Kategorin Layanan</label>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <input type="hidden" name="id" value="{{$v->id_kategorilayanan}}">
                    <input type="text" class="form-control" name="layanan"  value="{{$v->kategorilayanan}}" required placeholder="Kategori Layanan">
                   </div>
                  <div class="modal-footer">

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
