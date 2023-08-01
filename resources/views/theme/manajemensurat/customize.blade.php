@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
$level = Level::all();
 ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Template Surat</h1>
      <p>Menu untuk mengatur template surat</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard </a></li>
    </ul>
  </div>

<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Pengaturan Template : <b class="text-primary">{{$edit->nama_jenis_surat}}</b>
        <a href="{{url('template_surat')}}" style="color:white;"class="btn waves-effect waves-light btn-danger pull-right">Kembali</a>

      </h4>
      <br>
      <br>
      <table class="table">
        <thead>
          <tr>
            <th>Nama Variabel</th>
            <th>Jenis Isian</th>
            <th>Keterangan</th>
            <th style="width:50px">Aksi</th>
          </tr>
        </thead>
    <tbody>

        @foreach(DB::table('field_surat')->where('jenis_surat',$edit->id)->get() as $row)
        <tr>
          <td>{{ $row->field_type!='break' ? '${'.$row->field.'}' : ''}}</td>
          <td>{{$row->field_type}}</td>
          <td>{{$row->desc}}</td>
          <td><a href="{{url()->full().'?delete='.$row->id}}"> <i class="fa fa-trash text-danger" aria-hidden></i></a> </td>
        </tr>
        @endforeach
      </tbody>

      </table>
      <form action="{{URL::full()}}" method="post">
        @csrf
<table class="table">
  <tr>

 <td>

   <label for="email_address">Jenis Isian</label>
   <div class="form-group">
    <div class="form-line">
       <textarea onkeyup="if(this.value=='pegawai') {$(this).attr('readonly','readonly');$('.field').val(this.value);$('.field').attr('readonly','readonly')}else {$(this).removeAttr('readonly'); $('.field').val('');$('.field').removeAttr('readonly')}" type="text" name="field_type" class="form-control isian" placeholder="Jenis Isian" required></textarea
    </div>
    <p>Opsi : <?php $arr =  array("text","textarea","time","number","file","date","opsi1,opsi2","break","array_data","pegawai");?>
      @foreach($arr as $r)<small class="badge bg-warning" style="cursor:pointer" onclick="$('.isian').val('{{$r}}').keyup()">{{str_replace("\\","",$r)}}</small> @endforeach</p>
      </div>

     </td>

       <td>
         <label for="email_address">Variabel</label>
         <div class="form-group">
            <div class="form-line">
               <input  type="text" name="field" class="form-control field" placeholder="Masukkan Nama Variabel" required>
            </div>
         </div>

      </td>

     <td>
     <label for="email_address">Keterangan / Nilai</label>
     <div class="form-group">
        <div class="form-line">
           <textarea type="text" name="desc" class="form-control" placeholder="Keterangan Isian" required></textarea>
        </div>
     </div>
     <button class="btn btn-primary btn-sm pull-right" name="save" value="add"> <i class="fa fa-chevron-circle-right" aria-hidden></i> Simpan </button>
   </td>

</tr>

</table>


      </form>
    </div>
  </div>
</div>
</div>



</main>
@endsection
