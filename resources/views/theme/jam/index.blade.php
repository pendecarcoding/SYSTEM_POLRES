@extends('theme.Layouts.design')
@section('content')



<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-clock-o"></i> Data Jam Kantor</h1>
      <p></p>
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
        Jam Kerja Kantor
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="sampleTable">
            <thead>
              <tr>
              <th>Hari</th>
              <th>Jenis</th>
              <th>waktu</th>
              <th>Batas Waktu</th>

              <th width="10%"></th>
            </tr>
          </thead>
          <tbody>
            <?php $hari = array('senin','selasa','rabu','kamis','jumat'); ?>
           @foreach($hari as $vhari)
           <?php

           $jammasuk =  Helper::jam($vhari,'Jam Masuk',$ki);
           $jampulang = Helper::jam($vhari,'Jam Pulang',$ki);

            ?>
            <tr>
              <td rowspan="2"><b>{{$vhari}}</b></td>
              <td ><b>Jam Masuk</b></td>
              <td >{!!$jammasuk['jam']!!}</td>
              <td >{!!$jammasuk['batas']!!}</td>
              <td >
                <a data-toggle="modal" data-target="#jammasuk{{$vhari}}" style="color:white" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Atur Jam</a>
              </td>

            </tr>
            <tr>
                <td ><b>Jam Pulang</b></td>
                <td >{!!$jampulang['jam']!!}</td>
                <td >{!!$jampulang['batas']!!}</td>
                <td >
                  <a data-toggle="modal" data-target="#jamkeluar{{$vhari}}" style="color:white" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Atur Jam</a>
                </td>
            </tr>
            <div id="jamkeluar{{$vhari}}" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-clock-o"></i>Atur Jam Pulang Hari {{$vhari}}</h4>

              <button  type="button" class="btn btn-danger" style="float:right" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('addjamkerja')}}" method="post" >{{csrf_field()}}
            <div class="modal-body">


              <div class="form-group">
                <input type="hidden" name="hari" value="{{$vhari}}">
                <input type="hidden" name="jenis" value="Jam Pulang" class="form-control"  placeholder="Jenis Jam Kerja">
              </div>

              <label>Jam Absen</label>
              <div class="form-group">
                <input type="time" name="jam" value="{!!$jampulang['jam']!!}" class="form-control"  placeholder="Jam Absen">
              </div>

              <label>Batas Absen</label>
              <div class="form-group">
                <input type="time" name="batasabsen" value="{!!$jampulang['batas']!!}" class="form-control"  placeholder="Batas Absen">
              </div>

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>

        </div>
        </div>




            <div id="jammasuk{{$vhari}}" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-clock-o"></i>Atur Jam Masuk Hari {{$vhari}}</h4>

              <button  type="button" class="btn btn-danger" style="float:right" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('addjamkerja')}}" method="post" >{{csrf_field()}}
            <div class="modal-body">


              <div class="form-group">
                <input type="hidden" name="hari" value="{{$vhari}}">
                <input type="hidden" name="jenis" value="Jam Masuk" class="form-control"  placeholder="Jenis Jam Kerja">
              </div>

              <label>Jam Absen</label>
              <div class="form-group">
                <input type="time" name="jam" class="form-control" value="{!!$jammasuk['jam']!!}"  placeholder="Jam Absen">
              </div>

              <label>Batas Absen</label>
              <div class="form-group">
                <input type="time" name="batasabsen" value="{!!$jammasuk['batas']!!}" class="form-control"  placeholder="Batas Absen">
              </div>

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>

        </div>
      </div>
            @endforeach





          </tbody>
          </div>
        </div>
      </div>
      </div>



      </main>
@endsection
