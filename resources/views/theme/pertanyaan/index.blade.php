@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
$level = Level::all();
 ?>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Data Pertanyaan</h1>
      <p>Menu untuk mengatur Data Pertanyaan</p>
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
      <h4 class="card-title">Daftar Data Pertanyaan
        <a data-toggle='modal' href="#tambah" data-target="#tambah" style="color:white;"class="btn waves-effect waves-light btn-primary pull-right">Tambah Pertanyaan</a>
      </h4>
    </div>
    <div class="card-body">

      <!-- Modal -->
      <br><br>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
        <tr>
          <th>#</th>
          <th>Pertanyaan</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          @foreach($data as $index => $v)
          <tr>
            <td>{{$v->short}}</td>
            <td>{{$v->pertanyaan}}</td>
            <td>
               <a data-toggle='modal' href="#" data-target="#edit{{$v->id_pertanyaan}}">
                 <i class="fa fa-edit text-warning" aria-hidden=""></i> </a>   &nbsp;&nbsp;
                 <a onclick="return confirm('Yakin untuk menghapus?')" href="{{url('hapuspertanyaan/'.base64_encode($v->id_pertanyaan))}}">
                   <i class="fa fa-trash text-danger" aria-hidden=""></i>
                 </a>
              </td>
          </tr>

          <div class="modal fade" id="edit{{$v->id_pertanyaan}}" role="dialog">
            <div class="modal-dialog modal-md">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Update Data Pertanyaan</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>


                </div>
                <div class="modal-body">
                  <form class="" action="{{url('updatepertanyaan')}}" method="post">{{csrf_field()}}
                    <div class="form-group">
                      <label>NO Urut</label>
                    <input type="text" class="form-control" name="short" value="{{ $v->short }}">
                  </div>
                  <div class="form-group">
                    <label>Soal Pertanyaan</label>
                    <input type="hidden" name="id" value="{{$v->id_pertanyaan}}">
                  <textarea name="pertanyaan" class="form-control">{{ $v->pertanyaan }}</textarea>
                </div>
                <ul class="list-group">
                    <button type="submit" class="btn btn-primary" type="submit">Simpan</button>
                </ul>
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



<div class="modal fade" id="tambah" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Pelayanan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>


      </div>
      <div class="modal-body">
        <form class="" action="{{url('addpertanyaan')}}" method="post">{{csrf_field()}}
          <div class="form-group">
            <label>NO Urut</label>
          <input type="text" class="form-control" name="short" required>
        </div>
        <div class="form-group">
          <label>Soal Pertanyaan</label>
        <textarea name="pertanyaan" class="form-control" required></textarea>
      </div>
      </div>
      <ul class="list-group">
          <button type="submit" class="btn btn-primary" type="submit">Simpan</button>
      </ul>
       </form>
      </div>
    </div>
  </div>
      </div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
