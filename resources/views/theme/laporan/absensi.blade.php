<!DOCTYPE html>
<html>
<head>
  <style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
   
    table{
      width: 100%;
    }
    </style>
</head>
<body>
  <center><h3>REKAPITULASI DAFTAR HADIR PEGAWAI NEGERI SIPIL</h3></center>
  <table style="border: none;">
    <tr style="border: none;">
      <td style="border: none;">SATUAN KERJA</td>
      <td style="border: none;">:</td>
      <td style="border: none;">{{$instansi->nama_unitkerja}}</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;">Periode</td>
      <td style="border: none;">:</td>
      <td style="border: none;">{{$date}}</td>
    </tr>
  </table>
<table class="table table-hover table-bordered" id="tableabsen">
          <thead>
            <tr>
            <th rowspan="2" style="text-align:center">No</th>
            <th rowspan="2" style="text-align:center">NAMA/NIP</th>
            <th rowspan="2" style="text-align:center">PANGKAT/GOL</th>
            <th colspan="6" style="text-align:center">KETERANGAN KEHADIRAN (HARI KERJA)</th>
          </tr>
          <tr>
            <th style="text-align:center">H</th>
            <th style="text-align:center">D</th>
            <th style="text-align:center">C</th>
            <th style="text-align:center">S</th>
            <th style="text-align:center">A</th>
            <th style="text-align:center">P</th>
  

          </tr>
        </thead>
        <tbody>
          @foreach($dataabsen as $i =>$v)
          <tr>
            <td style="text-align: center;">{{$i+1}}</td>
            <td>{{$v['nama_pegawai']}}<br>NIP.{{$v['nip']}}</td>
            <td>{{$v['pangkat']}}</td>
            <td style="text-align: center;">{{$v['H']}}</td>
            <td style="text-align: center;">{{$v['D']}}</td>
             <td style="text-align: center;">{{$v['C']}}</td>
            <td style="text-align: center;">{{$v['S']}}</td>
            <td style="text-align: center;">{{$v['A']}}</td>
            <td style="text-align: center;">{{$v['P']}}</td>
          </tr>
          @endforeach
        </tbody>
        </table>
      </body>
      </html>