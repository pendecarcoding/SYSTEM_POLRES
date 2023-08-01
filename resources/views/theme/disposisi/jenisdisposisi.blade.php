@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
use App\AlurDispo;
use App\Jabatan;
use App\DispoJenis;
use App\TblAksi;
$level = Level::all();
 ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Jenis Disposisi</h1>
      <p>Menu untuk mengatur Jenis Disposisi</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>

  @include('theme.Layouts.alert')

 @if(isset($_GET['act']))
 @if($_GET['act']=='setting')
 <?php
  $datadispo = AlurDispo::where('kode_unitkerja',Session::get('kode_unitkerja'))
               ->where('id_disposisi',base64_decode($_GET['dta']))
               ->orderby('tahap','desc')
               ->get();
               $dispo = DispoJenis::where('kode_unitkerja',Session::get('kode_unitkerja'))
                            ->where('id',base64_decode($_GET['dta']))
                            ->first();
  $jb = Jabatan::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
  $taksi = TblAksi::all();
  ?>
 <div class="row">
 <div class="col-8">
   <div class="card">
     <div class="card-body">
       <h4 class="card-title">Aktor dalam Disposisi {{$dispo->jenis}}
         <a data-toggle='modal' href="#tambah" data-target="#tambahalur" style="color:white;"class="btn waves-effect waves-light btn-primary pull-right">Tambah Aktor</a>
       </h4>
       <!-- Modal -->
       <br><br>
       <div class="table-responsive">
         <table class="table table-hover table-bordered" id="sampleTable">
           <thead>
         <tr>
           <th>#</th>
           <th>Aktor</th>
           <th>Fungsi Aktor</th>
            <th>Tahap</th>
           <th>Aksi</th>
         </tr>
         </thead>
         <tbody>
           @foreach($datadispo as $index => $v)
           <tr>
             <td>{{$index+1}}</td>
             <td>{{$v->jabatan}}</td>
             <td>{{$v->aksi}}</td>
             <td>{{$v->tahap}}</td>

             <td><a data-toggle='modal' href="#tambah" data-target="#edit{{$v->id_alur}}">
                  <i class="fa fa-edit text-warning" aria-hidden=""></i> </a>   &nbsp;&nbsp;
                  <a onclick="return confirm('Yakin untuk menghapus?')" href="{{url('hapusaktor/'.base64_encode($v->id_alur))}}">
                    <i class="fa fa-trash text-danger" aria-hidden=""></i>
                  </a>
               </td>
           </tr>


           <div class="modal fade" id="edit{{$v->id_alur}}" role="dialog">
             <div class="modal-dialog modal-md">
               <!-- Modal content-->
               <div class="modal-content">
                 <div class="modal-header">
                   <h4 class="modal-title">Update Aktor Disposisi</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>


                 </div>
                 <div class="modal-body">
                   <form class="" action="{{url('updatealur')}}" method="post">{{csrf_field()}}
                     <input type="hidden" name="id" value="{{$v->id_alur}}">
                     <input type="hidden" name="id_disposisi" value="{{base64_decode($_GET['dta'])}}">
                   <div class="form-group">
                     <label>JABATAN</label>
                   <select class="form-control" name="jabatan">
                       <option>--Pilih Jabatan--</option>
                        @foreach($jb as $ijb => $vj)
                         <option value="{{$vj->id_jabatan}}" @if($v->id_jabatan==$vj->id_jabatan) selected @endif>{{$vj->jabatan}}</option>
                         @endforeach
                   </select>
                     <label>Fungsi Aktor</label>
                     <select class="form-control" name="aksi">
                       <option>--Pilih Fungsi--</option>
                       @foreach($taksi as $tiaksi => $vak)
                        <option value="{{$vak->aksi}}"@if($v->aksi==$vak->aksi) selected @endif>{{$vak->aksi}}</option>
                        @endforeach
                     </select>
                   </i>Aktor ini bisa melakukan apa ?</i>
                   <br>
                    <label>Tahapan</label>
                    <input type="number" name="tahap" value="{{$v->tahap}}" class="form-control">
                 </div>
                 <ul class="list-group">
                     <button class="btn btn-primary" type="submit">Update</button>
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
 <div class="col-4">
   <div class="card">
     <div class="card-header">
       <a href="{{url('alur_disposisi')}}" style="float:right;" class="btn btn-danger">x</a>
       <h4 class="card-title">Urutan Jenjang Disposisi
        </h4>

     </div>
     <div class="card-body">
       @foreach($datadispo as $index => $v)
       <div class="card-header">{{$v->jabatan}} ==> {{$v->aksi}} SURAT</div>
       @endforeach
     </div>


   </div>
 </div>
 </div>
 <div class="modal fade" id="tambahalur" role="dialog">
   <div class="modal-dialog modal-md">
     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">Tambah Aktor Disposisi</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>


       </div>
       <div class="modal-body">
         <form class="" action="{{url('tambahalur')}}" method="post">{{csrf_field()}}
           <input type="hidden" name="id_disposisi" value="{{base64_decode($_GET['dta'])}}">
         <div class="form-group">
           <label>JABATAN</label>
         <select class="form-control" name="jabatan">
             <option>--Pilih Jabatan--</option>
              @foreach($jb as $ijb => $vj)
               <option value="{{$vj->id_jabatan}}">{{$vj->jabatan}}</option>
               @endforeach
         </select>
           <label>Fungsi Aktor</label>
           <select class="form-control" name="aksi">
             <option>--Pilih Fungsi--</option>
             @foreach($taksi as $tiaksi => $vak)
              <option value="{{$vak->aksi}}">{{$vak->aksi}}</option>
              @endforeach
           </select>
         </i>Aktor ini bisa melakukan apa ?</i>
         <br>
          <label>Tahapan</label>
          <input type="number" name="tahap" value="" class="form-control">
       </div>
       <ul class="list-group">
           <button class="btn btn-primary" type="submit">Simpan</button>
       </ul>
        </form>
       </div>
     </div>
   </div>
       </div>
 @endif


 @else

<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Daftar Jenis Disposisi
        <a data-toggle='modal' href="#tambah" data-target="#tambah" style="color:white;"class="btn waves-effect waves-light btn-primary pull-right">Tambah Jenis</a>
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
          <th>Jenis</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          @foreach($data as $index => $v)
          <tr>
            <td>{{$index+1}}</td>
            <td>{{$v->jenis}}</td>
            <td><a href="{{url('alur_disposisi?act=setting&dta='.base64_encode($v->id))}}">
              <i class="fa fa-cogs" aria-hidden=""></i> </a> &nbsp;&nbsp;
               <a href="https://absensi.bengkaliskab.go.id/template_surat/edit/MTM=">
                 <i class="fa fa-edit text-warning" aria-hidden=""></i> </a>   &nbsp;&nbsp;
                 <a onclick="return confirm('Yakin untuk menghapus?')" href="https://absensi.bengkaliskab.go.id/template_surat?delete=MTM=">
                   <i class="fa fa-trash text-danger" aria-hidden=""></i>
                 </a>
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
@endif



</main>
<div class="modal fade" id="tambah" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Jenis Disposisi</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>


      </div>
      <div class="modal-body">
        <form class="" action="{{url('simpanjenisdispo')}}" method="post">{{csrf_field()}}
        <div class="form-group">
          <label>Jenis Disposisi</label>
        <input type="text" class="form-control" name="jenis" value="">
      </div>
      <ul class="list-group">
          <button class="btn btn-primary" type="submit">Simpan</button>
      </ul>
       </form>
      </div>
    </div>
  </div>
      </div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
