<?php
use App\Cmenu;
$class = new Cmenu();
 ?>
@extends('theme.Layouts.design')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fa fa-desktop"></i> Test Logika</h4>
      <h6 class="card-subtitle">Untuk Mengecheck Logika </h6>

      <form action="testlogika" method="get">{{csrf_field()}}
        <div class="row">
          <input placeholder="Input Budget" type="number" style="width:40%" class="form-control" name="budget">
          <input placeholder="Input Jumlah Tamu" type="number" style="width:40%" class="form-control" name="tamu">
          <button class="btn btn-primary" type="submit">TEST</button>
        </div>
      </form>


      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
          <th>Id</th>
          <th>Aturan</th>
        </tr>
        </thead>
        <tbody>
          <?php
          if(isset($_GET['budget']) AND isset($_GET['tamu'])){


            ?>
            <tr>
              <td>1</td>
              <td>if('budget' > 0) AND ('budget' <= 10.000.000) = RENDAH , if('tamu' > 0 AND 'tamu' <= 600) = SEDIKIT</td>
            </tr>
            <tr>
              <td>2</td>
              <td>if('budget' > 11.000.000) AND ('budget' <= 30.000.000) = SEDANG , if('tamu' > 601 AND 'tamu' <= 999) = SEDANG</td>
            </tr>

            <tr>
              <td>3</td>
              <td>if('budget' == 31.000.000) AND ('budget' >= 50.000.000) = BANYAK , if('tamu' > 1000 AND 'tamu' <= 2000) = BANYAK</td>
            </tr>



                      <?php
                    }
                    ?>
        </tbody>
        </table>


      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
          <th>#</th>
          <th>BUDGET</th>
          <th>TAMU</th>
          <th>PILIHAN PAKET</th>
          <th>HASIL</th>
        </tr>
        </thead>
        <tbody>
          <?php
          if(isset($_GET['budget']) AND isset($_GET['tamu'])){
            $data = (object) $class->treeshort($_GET['budget'],$_GET['tamu']);
            $jmlkasus = 0;
            $ya       = 0;
            $tidak    = 0;
            ?>
            @foreach($data as $index =>$v)
            <?php
            $jmlkasus++;
            if($v['hasil']=='YA'){
              $ya++;
            }
            if($v['hasil']=='TIDAK'){
              $tidak++;
            }
            ?>
            <tr>
              <td>{{$index+1}}</td>
              <td>{{$v['budget']}}</td>
              <td>{{$v['tamu']}}</td>
              <td>{{$v['paket']}}</td>
              <td>{{$v['hasil']}}</td>
            </tr>
            @endforeach
            <?php
          }
          ?>

        </tbody>
        </table>
      </div>


      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
          <th>JML KASUS</th>
          <th>YA</th>
          <th>TIDAK</th>
          <th>ENTROPY</th>
        </tr>
        </thead>
        <tbody>
          <?php
          if(isset($_GET['budget']) AND isset($_GET['tamu'])){


            ?>

            <tr>
              <td>{{$jmlkasus}}</td>
              <td>{{$ya}}</td>
              <td>{{$tidak}}</td>
              <td>{{$class->entrophy($ya,$tidak)}}


              </td>
            </tr>

          <tr>
            <td>Budget ({{$class->klasifikasibudget($_GET['budget'])}})</td>
            <td>{{$ya}}</td>
            <td>{{$tidak}}</td>
            <td>{{$class->entrophy($ya,$tidak)}}</td>
          </tr>

          <tr>
            <td>Tamu ({{$class->klasifikasitamu($_GET['tamu'])}})</td>
            <td>{{$ya}}</td>
            <td>{{$tidak}}</td>
            <td>{{$class->entrophy($ya,$tidak)}}</td>
          </tr>

                      <?php
                    }
                    ?>
        </tbody>
        </table>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
          <th>REKOM</th>
          <th>YA</th>
          <th>TIDAK</th>
          <th>ENTROPY</th>
        </tr>
        </thead>
        <tbody>
          <?php
          if(isset($_GET['budget']) AND isset($_GET['tamu'])){
            $data = (object) $class->treeshort($_GET['budget'],$_GET['tamu']);
            $jmlkasus = 0;
            $ya=0;
            $tidak=0;
            ?>
            @foreach($data as $index =>$v)
            <?php

            ?>
            <tr>

              <td>{{$v['paket']}}</td>
              <td>@if($v['hasil']=='YA'){{$ya+1}} @else {{$ya}}@endif</td>
              <td>@if($v['hasil']=='TIDAK'){{$tidak+1}} @else {{$tidak}}@endif</td>
              <td>{{$class->entrophy($ya,$tidak)}}</td>
            </tr>
            @endforeach
            <?php
          }
          ?>

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
