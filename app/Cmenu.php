<?php
namespace App;
use App\menu;
use App\aksesmenuModel;
use App\PaketModel;
use App\RouteModel;
use App\Loginmodel;
use App\AbsenModel;
use App\InstansiModel;
use App\KordinatModel;
use Helper;
use Session;
use DB;

ini_set('memory_limit', '-1');
class Cmenu
{



  function listroute(){
    $login = Session::get('login');
    if($login = TRUE){
        return Helper::get_route();
    }else{
      return redirect('login');
    }


  }

  // function getIdPegawai($id){
  //    try {
  //     $data = DB::table('')->where('')
  //    } catch (\Throwable $th) {
  //     //throw $th;
  //    }
  // }
  function recordabsen($iduser,$tglindex){
    $data = AbsenModel::where('id_pegawai',$iduser)->where('tglabsen',$tglindex)->first();
    if($data != null){
      return $data;
    }
  }
  function namainstansi($id){
    $check    = InstansiModel::where('kode_unitkerja',$id)->count();
    if($check > 0){
      $instansi = InstansiModel::where('kode_unitkerja',$id)->first();
      return $instansi;
    }

  }
  function listinstansi(){
   $data = InstansiModel::where('jenis','K')->where('status','A')->get();
   return $data;
  }
  function datamarker($ku){
  $datamarker = KordinatModel::where('latitude','!=','')
                ->where('longitude','!=','')
                ->where('kode_unitkerja',$ku)
                ->first();
   return $datamarker;
  }
  function getpegawai($id){
    $data = DB::table('tbl_pegawai')->where('id',$id)->count();
    if($data > 0){
      $data = DB::table('tbl_pegawai')->where('id',$id)->first();
      return $data;
    }
  }

  function getpegawaifromiduser($id){
    $data = DB::table('tbl_user')->join('tbl_pegawai','tbl_pegawai.id','tbl_user.id_pegawai')->where('id_pegawai',$id)->count();
    if($data > 0){
      $data = DB::table('tbl_user')->join('tbl_pegawai','tbl_pegawai.id','tbl_user.id_pegawai')->where('id_pegawai',$id)->first();
      return $data;
    }else{
      return false;
    }
  }

  function getpegawaifromidusers($id){
    $data = DB::table('tbl_user')->join('tbl_pegawai','tbl_pegawai.id','tbl_user.id_pegawai')->where('id_user',$id)->count();
    if($data > 0){
      $data = DB::table('tbl_user')->join('tbl_pegawai','tbl_pegawai.id','tbl_user.id_pegawai')->where('id_user',$id)->first();
      return $data;
    }else{
      return false;
    }
  }
  function getpegawaiinstansi($instansi){
    $d    = array();
    $data =  json_decode(file_get_contents('https://pinka.bengkaliskab.go.id/api/simpeg_induk_opt?BADAN-API-21=b4d4n_kpp21&kode_unitkerja='.$instansi), true);
    if($data != false) {
      $data =  json_decode(file_get_contents('https://pinka.bengkaliskab.go.id/api/simpeg_induk_opt?BADAN-API-21=b4d4n_kpp21&kode_unitkerja='.$instansi), true);
      return $data;
    }


  }

  function getprofilpgapino($api,$nip){
    $d    = array();
    $data =  json_decode(file_get_contents('https://pinka.bengkaliskab.go.id/api/simpeg_induk?BADAN-API-21=b4d4n_kpp21&no='.$nip), true);
    if($data != false) {
      $data =  json_decode(file_get_contents('https://pinka.bengkaliskab.go.id/api/simpeg_induk?BADAN-API-21=b4d4n_kpp21&no='.$nip), true);
      foreach ($data as $key => $value) {
        $namainstansi = (empty($this->namainstansi($value['kode_unitkerja'])->nama_unitkerja) ? '':$this->namainstansi($value['kode_unitkerja'])->nama_unitkerja);
        $d =[
          'no'=>$value['no'],
          'statuspeg'=>$value['statuspeg'],
          'nip_baru'=>$value['nip_baru'],
          'gd'=>$value['gd'],
          'nama'=>$value['nama'],
          'gb'=>$value['gb'],
          'tempat_lahir'=>$value['tempat_lahir'],
          'tanggal_lahir'=>$value['tanggal_lahir'],
          'agama'=>$value['agama'],
          'nik'=>$value['nik'],
          'npwp'=>$value['npwp'],
          'pangkat'=>$value['pangkat'],
          'gol'=>$value['gol'],
          'tmt_gol'=>$value['tmt_gol'],
          'eselon'=>$value['eselon'],
          'tk_pddkn'=>$value['tk_pddkn'],
          'kode_unitkerja'=>$value['kode_unitkerja'],
          'nama_pimpinan'=>$value['nama_pimpinan'],
          'sub_unor'=>$value['sub_unor'],
          'nama_jabatan'=>$value['nama_jabatan'],
          'kode_jabatan'=>$value['kode_jabatan'],
          'statushidup'=>$value['statushidup'],
          'status_rumah'=>$value['status_rumah'],
          'no_hp'=>$value['no_hp'],
          'email'=>$value['email'],
          'alamat_peg'=>$value['alamat_peg'],
          'foto'=>$this->does_url_exists($value['no']),
          'kecamatan'=>$value['kecamatan'],
          'url'=>'apipinka',
          'nama_unitkerja'=>$namainstansi
        ];
      }
        return $d;
    }else{
        return redirect('datapegawai');
    }


  }

  function getprofilpgapi($nip){
    $d    = array();
    $data =  json_decode(file_get_contents('https://pinka.bengkaliskab.go.id/api/simpeg_induk?BADAN-API-21=b4d4n_kpp21&no='.$nip), true);
    if($data != false) {
      $data =  json_decode(file_get_contents('https://pinka.bengkaliskab.go.id/api/simpeg_induk?BADAN-API-21=b4d4n_kpp21&no='.$nip), true);
      foreach ($data as $key => $value) {
        $d =[
          'kode_unitkerja'=>$value['kode_unitkerja'],
        ];
      }
    }else{
      $d =[
        'kode_unitkerja'=>'0',
      ];
    }
    return $d;

  }
  function tgl_indos($tanggal){
    $bulan = array (
      1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun
   
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
  }
  function gethari($tanggal){
    $namahari = date('l', strtotime($tanggal));
    $daftar_hari = array(
      'Sunday' => 'minggu',
      'Monday' => 'senin',
      'Tuesday' => 'selasa',
      'Wednesday' => 'rabu',
      'Thursday' => 'kamis',
      'Friday' => 'jumat',
      'Saturday' => 'sabtu'
      );
     $hari = $daftar_hari[$namahari];
     return $hari;
  }

  function tgl_indo($tanggal){
    if($tanggal <> '0000-00-00'){
      $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      );



      $pecahkan = explode('-', $tanggal);

      // variabel pecahkan 0 = tanggal
      // variabel pecahkan 1 = bulan
      // variabel pecahkan 2 = tahun

      $tanggals  =  $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
      $namahari = date('l', strtotime($tanggal));
      $daftar_hari = array(
 'Sunday' => 'minggu',
 'Monday' => 'Senin',
 'Tuesday' => 'Selasa',
 'Wednesday' => 'Rabu',
 'Thursday' => 'Kamis',
 'Friday' => 'Jumat',
 'Saturday' => 'Sabtu'
);
      $data = array(
        'tgl'=>$daftar_hari[$namahari].','.$tanggals,
        'tglindex'=>$tanggal,
        'color'=>($daftar_hari[$namahari] == 'Minggu' OR $daftar_hari[$namahari] == 'Sabtu' ) ? '#e0c3c3':''
      );
      return $data;

    }else{
      $nilai = '-';
      return $nilai;
    }

  }

  function does_url_exists($url) {
    $ch = curl_init("https://pinka.bengkaliskab.go.id/assets/images/asn/".$url.'.jpg');
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($code == 200) {
        $status ="https://pinka.bengkaliskab.go.id/assets/images/asn/".$url.'.jpg';
    } else {
        $status = "http://skp.bengkaliskab.go.id/userskp/noimage.png";
    }
    curl_close($ch);
    return $status;
}

  function getuser($id){
    $data = Loginmodel::where('id_user',$id)->first();
    return $data;
  }
  function getside($level){
    $level = aksesmenuModel::where('level',$level)->first();
    $lvarr = explode(',',$level->id_menu);
    $data  = menu::where('type','side')
             ->where('active','Y')
             ->whereIn('id_side',$lvarr)

             ->orderBy('sortby','ASC')
             ->get();
    return($data);
  }



  function getsub($id,$level){
    $lvarr = explode(',',$id);
    $data  = menu::where('type','side')
             ->where('active','Y')
             ->whereIn('id_side',$lvarr)

             ->orderBy('sortby','ASC')
             ->get();
    return($data);
  }

  function checkpaket($id){
    $paket = PaketModel::where('id_paket',$id)->first();
    return $paket;
  }
  function curl_get_file_contents($URL)
      {
          $c = curl_init();
          curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($c, CURLOPT_URL, $URL);
          $contents = curl_exec($c);
          curl_close($c);

          if ($contents) return $contents;
          else return FALSE;
      }
  function getheader($level){
    $level = aksesmenuModel::where('level',$level)->first();
    $lvarr = explode(',',$level->id_menu);
    $data = menu::where('type','header')
             ->where('active','Y')
             ->whereIn('id_side',$lvarr)
             ->orderBy('sortby','ASC')
             ->get();
    return($data);
  }


  //Pengelompokan Budget
  function klasifikasibudget($jumlah){
    $klasifikasi = null;
    if($jumlah >= 0 AND $jumlah <= 10000000){
      $klasifikasi ='rendah';
    }elseif ($jumlah >= 11000000 AND $jumlah <= 30000000) {
      $klasifikasi ='sedang';
    }
    elseif ($jumlah >= 31000000 AND $jumlah <= 50000000) {
      $klasifikasi ='tinggi';
    }else{
      $klasifikasi ='Tidak Masuk Kategori';
    }
      return $klasifikasi;
  }
  //Pengelompokan Budget
  function klasifikasitamu($jumlah){
    $klasifikasi = null;
    if($jumlah >= 0 AND $jumlah <= 500){
      $klasifikasi ='sedikit';
    }elseif ($jumlah >= 501 AND $jumlah <= 750) {
      $klasifikasi ='sedang';
    }
    elseif ($jumlah >= 751 AND $jumlah <= 1000) {
      $klasifikasi ='banyak';
    }else{
      $klasifikasi ='Tidak Masuk Kategori';
    }
    return $klasifikasi;
  }

  function treelogic($budget,$tamu,$paket,$tp){
      $kbudget = $this->klasifikasibudget($budget);
      $ktamu   = $this->klasifikasitamu($tamu);
      $hasil   = null;
      //tinggi
      if($kbudget=='tinggi' AND $ktamu=='banyak'){
        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }
          if($paket=='E'){
            $hasil ='YA';
          }
          if($paket=='F'){
            $hasil ='YA';
          }
        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
        }

        //Fatma Dewi
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }

        //CMS
        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }

        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }


      }
      if($kbudget=='tinggi' AND $ktamu=='sedang'){
          if($tp=='1'){
            if($paket=='A'){
              $hasil = 'YA';
            }
            if($paket=='B'){
              $hasil ='YA';
            }
            if($paket=='C'){
              $hasil ='YA';
            }
            if($paket=='D'){
              $hasil ='YA';
            }
            if($paket=='E'){
            $hasil ='YA';
            }
            if($paket=='F'){
            $hasil ='YA';
            }

          }
          if($tp=='2'){
            if($paket=='A'){
              $hasil = 'YA';
            }
            if($paket=='B'){
              $hasil ='YA';
            }
            if($paket=='C'){
              $hasil ='YA';
            }
          }
          if($tp=='3'){
            if($paket=='A'){
              $hasil = 'YA';
            }
            if($paket=='B'){
              $hasil ='YA';
            }
            if($paket=='C'){
              $hasil ='YA';
            }

          }
          //CMS
          if($tp=='4'){
            if($paket=='A'){
              $hasil = 'YA';
            }
            if($paket=='B'){
              $hasil ='YA';
            }
            if($paket=='C'){
              $hasil ='YA';
            }

          }

          if($tp=='5'){
            if($paket=='A'){
              $hasil = 'YA';
            }
            if($paket=='B'){
              $hasil ='YA';
            }
            if($paket=='C'){
              $hasil ='YA';
            }
            if($paket=='D'){
              $hasil ='YA';
            }

          }
          if($tp=='6'){
            if($paket=='A'){
              $hasil = 'YA';
            }
            if($paket=='B'){
              $hasil ='YA';
            }
            if($paket=='C'){
              $hasil ='YA';
            }
            if($paket=='D'){
              $hasil ='YA';
            }

          }

      }
      if($kbudget=='tinggi' AND $ktamu=='sedikit'){

        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }
          if($paket=='E'){
          $hasil ='YA';
        }if($paket=='F'){
          $hasil ='YA';
        }


        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
        }
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }
        //CMS
        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }

        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
      }

      //sedang
      if($kbudget=='sedang' AND $ktamu=='banyak'){
        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }
          if($paket=='E'){
          $hasil ='YA';
          }
          if($paket=='F'){
          $hasil ='YA';
          }

        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
        }
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }
        //CMS
        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }

        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }


        }
      }


      if($kbudget=='sedang' AND $ktamu=='sedang'){
        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }
          if($paket=='E'){
          $hasil ='YA';
          }
          if($paket=='F'){
          $hasil ='YA';
          }

        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
        }
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }
        //CMS
        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }
        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
      }

      if($kbudget=='sedang' AND $ktamu=='sedikit'){
        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }
          if($paket=='E'){
          $hasil ='YA';
          }
          if($paket=='F'){
          $hasil ='YA';
          }

        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
        }
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }
        //CMS
        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }

        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
      }

      //rendah
      if($kbudget=='rendah' AND $ktamu=='banyak'){
        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
          if($paket=='D'){
            $hasil ='TIDAK';
          }
          if($paket=='E'){
          $hasil ='TIDAK';
          }
          if($paket=='F'){
          $hasil ='TIDAK';
          }
          //CMS


        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
        }
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }

        }

        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }

        }
        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
          if($paket=='D'){
            $hasil ='TIDAK';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
          if($paket=='D'){
            $hasil ='TIDAk';
          }

        }
      }
      if($kbudget=='rendah' AND $ktamu=='sedang'){
        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
          if($paket=='D'){
            $hasil ='TIDAK';
          }
          if($paket=='E'){
          $hasil ='TIDAK';
          }
          if($paket=='F'){
          $hasil ='YA';
          }

        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
        }
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }

        }
        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }
        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='TIDAK';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
          if($paket=='D'){
            $hasil ='TIDAK';
          }

        }
      }
      if($kbudget=='rendah' AND $ktamu=='sedikit'){
        if($tp=='1'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='TIDAK';
          }
          if($paket=='C'){
            $hasil ='TIDAK';
          }
          if($paket=='D'){
            $hasil ='YA';
          }
          if($paket=='E'){
          $hasil ='YA';
          }
          if($paket=='F'){
          $hasil ='YA';
          }

        }
        if($tp=='2'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
        }
        if($tp=='3'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }

        if($tp=='4'){
          if($paket=='A'){
            $hasil = 'YA';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }

        }
        if($tp=='5'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
        if($tp=='6'){
          if($paket=='A'){
            $hasil = 'TIDAK';
          }
          if($paket=='B'){
            $hasil ='YA';
          }
          if($paket=='C'){
            $hasil ='YA';
          }
          if($paket=='D'){
            $hasil ='YA';
          }

        }
      }

      return $hasil;


  }

  function entrophy($ya,$tidak){
    $rya = ($ya > 0)?(-($ya/6)*log($ya / 6, 2)):0;
    $rtd = ($tidak > 0)?(($tidak/6)*log($tidak / 6, 2)):0;
    $f = $rya+$rtd;
    return $f;
  }
  function treeshort($budget,$tamu){
    $result = array();
    $huruf  =  array("A", "B", "C", "D","E","F");
    foreach ($huruf as $value) {
      $hasil = $this->treelogic($budget,$tamu,$value,null);
      $datas=[
        "budget"=>$budget,
        "tamu"=> $tamu,
        "paket"=> $value,
        "hasil"=> $hasil
      ];
      array_push($result,$datas);


    }
    return $result;

  }




  function getnavbar($level){
    $level = aksesmenuModel::where('level',$level)->first();
    $lvarr = explode(',',$level->id_menu);
    $data = menu::where('type','navbar')
             ->where('active','Y')
             ->whereIn('id_side',$lvarr)
             ->orderBy('sortby','ASC')
             ->get();
    return($data);
  }

}
