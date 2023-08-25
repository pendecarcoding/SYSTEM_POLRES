@extends('theme.Layouts.design')
@section('content')
<?php
use App\Level;
$level = Level::all();
 ?>

<main class="app-content">
  
 @include('theme.Layouts.alert')
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Grafik IKM (Index Kepuasan Masyarakat)
        {{-- <a data-toggle='modal' href="#tambah" data-target="#tambah" style="color:white;"class="btn waves-effect waves-light btn-primary pull-right">Tambah Pelayanan</a> --}}
      </h4>
    </div>
    <div class="card-body">
        <figure class="highcharts-figure">
            <div id="container"></div>
            <p class="highcharts-description">
               
            </p>
        </figure>
        <script>
            Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik IKM (Index Kepuasan Masyarakat)',
        align: 'left'
    },
    
    xAxis: {
        categories: ['USA', 'China', 'Brazil', 'EU', 'India', 'Russia'],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Orang'
        }
    },
    tooltip: {
        valueSuffix: 'Orang'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Sangat Tidak Sesuai',
            data: [406292, 260000, 107000, 68300, 27500, 14500]
        },
        {
            name: 'Tidak Sesuai',
            data: [51086, 136000, 5500, 141000, 107180, 77000]
        },
        {
            name: 'Kurang Sesuai',
            data: [406292, 260000, 107000, 68300, 27500, 14500]
        },
        {
            name: 'Cukup Sesuai',
            data: [51086, 136000, 5500, 141000, 107180, 77000]
        },
        {
            name: 'Sesuai',
            data: [51086, 136000, 5500, 141000, 107180, 77000]
        },
        {
            name: 'Sangat Sesuai',
            data: [51086, 136000, 5500, 141000, 107180, 77000]
        }
    ]
});

        </script>
  
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
