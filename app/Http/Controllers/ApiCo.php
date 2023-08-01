<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use App\Sp2hpModel;
use Session;
use App\Gurumodel;
use App\Siswamodel;
use App\Jadwal;
use App\Layanan;
use App\Mengajar;
use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManagerStatic as Image;
class ApiCo extends Controller
{

  public function detailjadwalguru($id){

  }

  public function detailpemesanan($id){
    $check = Jadwal::where('jadwals.id_jadwal',$id)
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->count();
    if($check > 0){
      $data = Jadwal::where('jadwals.id_jadwal',$id)
              ->join('kategorilayanans',
              'kategorilayanans.id_kategorilayanan',
              'jadwals.id_kategorilayanan')
              ->join('gurus','gurus.id_guru','jadwals.id_guru')
              ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
              ->first();
      $field = [
        'message'=>'OK',
        'id'=>$data->id_jadwal,
        'nama'=>$data->nama_guru,
        'kategori'=>$data->kategorimengajar,
        'layanan'=>$data->kategorilayanan,
        'alamat'=>$data->nama_guru,
        'pertemuan'=>$data->pertemuan.' x Pertemuan',
        'hari'=>$data->hari,
        'jam'=>$data->jam_mulai.'-'.$data->jam_selesai,
        'jk'=>$data->jenis_kelamin,
        'tarif'=>$data->tarif,
        'foto'=>asset('guru/'.$data->image)
      ];
      print json_encode($field);
    }else{

    }
  }
  public function carilayanan($kunci){
    $data = Jadwal::where('gurus.nama_guru','LIKE','%'.$kunci.'%')
            ->orwhere('kategorilayanans.kategorilayanan','LIKE','%'.$kunci.'%')
            ->orwhere('kategorimengajars.kategorimengajar','LIKE','%'.$kunci.'%')
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->get();
    $result = array();
    foreach ($data as $key => $value) {
      array_push($result,array(
        'id'=>$value->id_jadwal,
        'nama'=>$value->nama_guru,
        'katlayanan'=>$value->kategorilayanan,
        'katmengajar'=>$value->kategorimengajar
      ));
    }
    echo json_encode($result);
  }
  public function tahfidz(){
    $data = Jadwal::where('kategorimengajars.kategorimengajar','Tahfidz')
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->get();
    $result = array();
    foreach ($data as $key => $value) {
      array_push($result,array(
        'id'=>$value->id_jadwal,
        'jk'=>$value->jenis_kelamin,
        'nama'=>$value->nama_guru,
        'riwayatselesai'=>'0',
        'kuota'=>$value->kuota.' Siswa',
        'alamat'=>$value->alamat
      ));
    }
    echo json_encode($result);
  }
  public function tahsin(){
    $data = Jadwal::where('kategorimengajars.kategorimengajar','Tahsin')
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->get();
    $result = array();
    foreach ($data as $key => $value) {
      array_push($result,array(
        'id'=>$value->id_jadwal,
        'jk'=>$value->jenis_kelamin,
        'nama'=>$value->nama_guru,
        'riwayatselesai'=>'0',
        'kuota'=>$value->kuota.' Siswa',
        'alamat'=>$value->alamat
      ));
    }
    echo json_encode($result);
  }
  public function pratahsin(){
    $data = Jadwal::where('kategorimengajars.kategorimengajar','Pra Tahsin')
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->get();
    $result = array();
    foreach ($data as $key => $value) {
      array_push($result,array(
        'id'=>$value->id_jadwal,
        'jk'=>$value->jenis_kelamin,
        'nama'=>$value->nama_guru,
        'riwayatselesai'=>'0',
        'kuota'=>$value->kuota.' Siswa',
        'alamat'=>$value->alamat
      ));
    }
    echo json_encode($result);
  }
  public function listmendatangiguruid($id=null){
    $check = Jadwal::where('kategorilayanans.kategorilayanan','Mendatangi Guru')
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->where('gurus.id_guru',$id)
            ->count();
    if($check > 0){
      $data = Jadwal::where('kategorilayanans.kategorilayanan','Mendatangi Guru')
              ->join('kategorilayanans',
              'kategorilayanans.id_kategorilayanan',
              'jadwals.id_kategorilayanan')
              ->join('gurus','gurus.id_guru','jadwals.id_guru')
              ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
              ->where('gurus.id_guru',$id)
              ->first();
              $hari   = explode(',',$data->hari);
              $result = array();

              foreach ($hari as $key) {
                array_push($result,array(
                  'hari'=>$key,
                  'jam'=>$data->jam_mulai.'-'.$data->jam_selesai,
                  'jumlah'=>$data->kuota
                ));
              }
              $head   = [
                'id_jadwal'=>$data->id_jadwal,
                'id_guru'=>$data->id_guru,
                'id_kategorilayanan'=>$data->id_kategorilayanan,
                'data'=>$result
              ];
                echo json_encode($head);
    }else{

    }

  }
  public function listmendatangimuridid($id=null){
    $check = Jadwal::where('kategorilayanans.kategorilayanan','Di Datangi Guru')
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->where('gurus.id_guru',$id)
            ->count();
    if($check > 0){
      $data   = Jadwal::where('kategorilayanans.kategorilayanan','Di Datangi Guru')
              ->join('kategorilayanans',
              'kategorilayanans.id_kategorilayanan',
              'jadwals.id_kategorilayanan')
              ->join('gurus','gurus.id_guru','jadwals.id_guru')
              ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
              ->where('gurus.id_guru',$id)
              ->count();
      $hari   = explode(',',$data->hari);
      $result = array();
      foreach ($hari as $key) {
        array_push($result,array(
          'hari'=>$key,
          'jam'=>$data->jam_mulai.'-'.$data->jam_selesai,
          'jumlah'=>$data->kuota
        ));
      }
      echo json_encode($result);
    }else{

    }

  }
  public function listmendatangimurid(){
    $data = Jadwal::where('kategorilayanans.kategorilayanan','Di Datangi Guru')
            ->join('kategorilayanans',
            'kategorilayanans.id_kategorilayanan',
            'jadwals.id_kategorilayanan')
            ->join('gurus','gurus.id_guru','jadwals.id_guru')
            ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
            ->get();
    $result = array();
    foreach ($data as $key => $value) {
      array_push($result,array(
        'id'=>$value->id_jadwal,
        'jk'=>$value->jenis_kelamin,
        'nama'=>$value->nama_guru,
        'riwayatselesai'=>'0',
        'kuota'=>$value->kuota.' Siswa',
        'alamat'=>$value->alamat
      ));
    }
    echo json_encode($result);
  }
public function listmendatangiguru(){
  $data = Jadwal::where('kategorilayanans.kategorilayanan','Mendatangi Guru')
          ->join('kategorilayanans',
          'kategorilayanans.id_kategorilayanan',
          'jadwals.id_kategorilayanan')
          ->join('gurus','gurus.id_guru','jadwals.id_guru')
          ->join('kategorimengajars','kategorimengajars.id_kategorimengajar','jadwals.id_kategorimengajar')
          ->get();
  $result = array();
  foreach ($data as $key => $value) {
    array_push($result,array(
      'id'=>$value->id_jadwal,
      'jk'=>$value->jenis_kelamin,
      'nama'=>$value->nama_guru,
      'riwayatselesai'=>'0',
      'kuota'=>$value->kuota.' Siswa',
      'alamat'=>$value->alamat
    ));
  }
  echo json_encode($result);
}

public function logingoogle(Request $r){
  if($r->has('type')){
    $email = $r->email;
    if($r->type=='siswa'){
      $check = Siswamodel::where('email',$email)
               ->count();
      if($check > 0){
        $data = Siswamodel::where('email',$email)
                 ->first();
       $field =[
         'message'=>'OK',
         'id'=>$data->id_siswa,
         'nama'=>$data->nama_siswa,
         'email'=>$data->email
       ];
       print JSON_ENCODE($field);
     }else{
       $data =[
         'nama_siswa'=>$r->nama,
         'email'=>$r->email,
         'image'=>'avatar.png',
         'password'=>md5(uniqid())
       ];
       $act = Siswamodel::insertGetId($data);
       if(!$act){
        $field =[
          'message'=>'FAIL',
          'id'=>null,
          'nama'=>null,
          'email'=>null
        ];
        print JSON_ENCODE($field);
       }else{
         $data = Siswamodel::where('id_siswa',$act)
                  ->first();
        $field =[
          'message'=>'OK',
          'id'=>$data->id_siswa,
          'nama'=>$data->nama_siswa,
          'email'=>$data->email
        ];
        print JSON_ENCODE($field);
       }

     }
    }
    else{
      $check = Gurumodel::where('email',$email)
               ->count();
      if($check > 0){
        $data = Gurumodel::where('email',$email)
                 ->first();
       $field =[
         'message'=>'OK',
         'id'=>$data->id_guru,
         'nama'=>$data->nama_guru,
         'email'=>$data->email
       ];
       print JSON_ENCODE($field);
     }else{
       $data =[
         'nama_guru'=>$r->nama,
         'email'=>$r->email,
         'image'=>'avatar.png',
         'password'=>md5(uniqid())
       ];
       $act = Gurumodel::insertGetId($data);
       if(!$act){
         $field =[
           'message'=>'FAIL',
           'id'=>null,
           'nama'=>null,
           'email'=>null
         ];
         print JSON_ENCODE($field);
       }else{
        $data = Gurumodel::where('id_guru',$act)
                  ->first();
        $field =[
          'message'=>'OK',
          'id'=>$data->id_guru,
          'nama'=>$data->nama_guru,
          'email'=>$data->email
        ];
        print JSON_ENCODE($field);
       }
     }
    }
  }
}
//SISWA
public function updatesiswa(Request $r){
  $photo = $r->foto;
  $photo = str_replace('data:image/png;base64,', '', $photo);
  $photo = str_replace(' ', '+', $photo);
  $data = base64_decode($photo);
  $file = uniqid() . '.png';
  $profil = Siswamodel::where('id_siswa',$r->id)->first();
  if(file_exists(public_path().'/siswa/'.$profil->image) AND $profil->image <>'avatar.png'){
    unlink(public_path().'/siswa/'.$profil->image);
  }
  file_put_contents(public_path().'/siswa/'.$file, $data);

  $data=[
          'email'=>$r->email,
          'nama_siswa'=>$r->nama,
          'jenis_kelamin'=>$r->jk,
          'no_hp'=>$r->nohp,
          'kontak_ortu'=>$r->kontak_ortu,
          'alamat'=>$r->alamat,
          'image'=>$file
        ];
        $act = Siswamodel::where('id_siswa',$r->id)->update($data);
        if(!$act){
          $field = [
            'message'=>'FAIL'
          ];
          print JSON_ENCODE($field);
        }else{
          $field = [
            'message'=>'OK'
          ];
          print JSON_ENCODE($field);
        }

}
public function updateguru(Request $r){
  $photo = $r->foto;
  $photo = str_replace('data:image/png;base64,', '', $photo);
  $photo = str_replace(' ', '+', $photo);
  $data = base64_decode($photo);
  $file = uniqid() . '.png';
  $profil = Gurumodel::where('id_siswa',$r->id)->first();
  if(file_exists(public_path().'/guru/'.$profil->image) AND $profil->image <>'avatar.png'){
    unlink(public_path().'/guru/'.$profil->image);
  }
  file_put_contents(public_path().'/guru/'.$file, $data);
  $data=[
          'email'=>$r->email,
          'nama_guru'=>$r->nama,
          'jenis_kelamin'=>$r->jk,
          'no_hp'=>$r->nohp,
          'image'=>$file
        ];
        $act = Gurumodel::where('id_guru',$r->id)->update($data);
        if(!$act){
          $field = [
            'message'=>'FAIL'
          ];
          print JSON_ENCODE($field);
        }else{
          $field = [
            'message'=>'OK'
          ];
          print JSON_ENCODE($field);
        }

}
public function daftarsiswa(Request $r){
  $type = $r->type;
  if($type=='google'){
    $check = Siswamodel::where('email',$r->email)->count();
    if($check > 0){
      $profil = Siswamodel::where('email',$r->email)->first();
      $field=[
        'message'=>'OK',
        'id'=>$profil->id_siswa
      ];
      print JSON_ENCODE($field);
    }else{
      $data =[
        'nama_siswa'=>$r->nama,
        'email'=>$r->email,
        'image'=>'avatar.png',
        'password'=>md5(uniqid())
      ];
      $act = Siswamodel::insertGetId($data);
      if(!$act){
        $field=[
          'message'=>'FAIL',
          'id'=>NULL
        ];
        print JSON_ENCODE($field);
      }else{
        $field=[
          'message'=>'OK',
          'id'=>$act
        ];
        print JSON_ENCODE($field);
      }
    }

  }else{
    if($r->has(['pass1','pass2','nama','email','jk'])){
      $pass1 = $r->pass1;
      $pass2 = $r->pass2;
      $pass  = $pass2;
      $jk    = $r->jk;
      if($pass1 <> $pass2){
        $field =[
          'message'=>'pass no match',
          'id'=>null
        ];
        print JSON_ENCODE($field);
      }else{
        $data =[
          'nama_siswa'=>$r->nama,
          'email'=>$r->email,
          'jenis_kelamin'=>$r->jk,
          'image'=>'avatar.png',
          'password'=>md5($pass)
        ];
        $act = Siswamodel::insertGetId($data);
        if(!$act){
          $field=[
            'message'=>'FAIL',
            'id'=>NULL
          ];
          print JSON_ENCODE($field);
        }else{
          $field=[
            'message'=>'OK',
            'id'=>$act
          ];
          print JSON_ENCODE($field);
        }
      }

    }else{
      $field=[
        'message'=>'FAIL',
        'id'=>NULL
      ];
      print JSON_ENCODE($field);
    }
  }


}
 public function daftarguru(Request $r){

   if($r->has('type')){
     $type = $r->type;
     if($type=='google'){
       $check = Gurumodel::where('email',$r->email)->count();
       if($check > 0){
         $profil = Gurumodel::where('email',$r->email)->first();
         $field=[
           'message'=>'OK',
           'id'=>$profil->id_guru
         ];
         print JSON_ENCODE($field);
       }else{
         $data =[
           'nama_guru'=>$r->nama,
           'email'=>$r->email,
           'image'=>'avatar.png',
           'password'=>md5(uniqid())
         ];
         $act = Gurumodel::insertGetId($data);
         if(!$act){
           $field=[
             'message'=>'FAIL',
             'id'=>NULL
           ];
           print JSON_ENCODE($field);
         }else{
           $field=[
             'message'=>'OK',
             'id'=>$act
           ];
           print JSON_ENCODE($field);
         }
       }

     }else{
       if($r->has(['pass1','pass2','nama','email'])){
         $pass1 = $r->pass1;
         $pass2 = $r->pass2;
         $pass  = $pass2;
         if($pass1 <> $pass2){
           $field =[
             'message'=>'pass no match',
             'id'=>null
           ];
           print JSON_ENCODE($field);
         }else{
           $data =[
             'nama_guru'=>$r->nama,
             'email'=>$r->email,
             'image'=>'avatar.png',
             'password'=>md5($pass)
           ];
           $act = Gurumodel::insertGetId($data);
           if(!$act){
             $field=[
               'message'=>'FAIL',
               'id'=>NULL
             ];
             print JSON_ENCODE($field);
           }else{
             $field=[
               'message'=>'OK',
               'id'=>$act
             ];
             print JSON_ENCODE($field);
           }
         }

       }else{
         $field=[
           'message'=>'FAIL',
           'id'=>NULL
         ];
         print JSON_ENCODE($field);
       }
     }
   }
   else{
     $field=[
       'message'=>'FAIL',
       'id'=>NULL
     ];
     print JSON_ENCODE($field);
   }



 }

 public function getdataguru($id=null){
   $check = Gurumodel::where('id_guru',$id)->count();
   if($check > 0){
     $data = Gurumodel::where('id_guru',$id)->first();
     $field = [
       'message'=>'OK',
       'id'=>$data->id_guru,
       'email'=>$data->email,
       'nama'=>$data->nama_guru,
       'jk'=>$data->jenis_kelamin,
       'nohp'=>$data->no_hp,
       'foto'=>asset('guru/'.$data->image)
     ];
     print json_encode($field);
   }else{
     $field = [
       'message'=>'FAIL',
       'id'=>NULL,
       'email'=>NULL,
       'nama'=>NULL,
       'jk'=>NULL,
       'nohp'=>NULL,
       'foto'=>NULL
     ];
     print json_encode($field);
   }
 }

 public function getdatasiswa($id=null){
   $check = Siswamodel::where('id_siswa',$id)->count();
   if($check > 0){
     $data = Siswamodel::where('id_siswa',$id)->first();
     $field = [
       'message'=>'OK',
       'id'=>$data->id_siswa,
       'email'=>$data->email,
       'nama'=>$data->nama_siswa,
       'jk'=>$data->jenis_kelamin,
       'nohp'=>$data->no_hp,
       'nohp_orangtua'=>$data->kontak_ortu,
       'alamat'=>$data->alamat,
       'foto'=>asset('siswa/'.$data->image)
     ];
     print json_encode($field);
   }else{
     $field = [
       'message'=>'FAIL',
       'id'=>NULL,
       'email'=>NULL,
       'nama'=>NULL,
       'jk'=>NULL,
       'nohp'=>NULL,
       'foto'=>NULL
     ];
     print json_encode($field);
   }
 }

 public function loginsiswa(Request $r){
 if($r->has(['email','password'])){
   $email = $r->email;
   $pass  = md5($r->password);
   $check = Siswamodel::where('email',$email)
            ->where('password',$pass)
            ->count();
   if($check > 0){
     $data = Siswamodel::where('email',$email)
              ->where('password',$pass)
              ->first();
    $field =[
      'message'=>'OK',
      'id'=>$data->id_siswa,
      'nama'=>$data->nama_siswa,
      'email'=>$data->email
    ];
    print JSON_ENCODE($field);
   }
   else{
     $field =[
       'message'=>'FAIL',
       'id'=>NULL,
       'nama'=>NULL,
       'email'=>NULL
     ];
     print JSON_ENCODE($field);
   }
 }
 else{
   $field =[
     'message'=>'FAIL',
     'id'=>NULL,
     'nama'=>NULL,
     'email'=>NULL
   ];
   print JSON_ENCODE($field);
 }
}

 public function loginguru(Request $r){
 if($r->has(['email','password'])){
   $email = $r->email;
   $pass  = md5($r->password);
   $check = Gurumodel::where('email',$email)
            ->where('password',$pass)
            ->count();
   if($check > 0){
     $data = Gurumodel::where('email',$email)
              ->where('password',$pass)
              ->first();
    $field =[
      'message'=>'OK',
      'id'=>$data->id_guru,
      'nama'=>$data->nama_guru,
      'email'=>$data->email
    ];
    print JSON_ENCODE($field);
   }
   else{
     $field =[
       'message'=>'FAIL',
       'id'=>NULL,
       'nama'=>NULL,
       'email'=>NULL
     ];
     print JSON_ENCODE($field);
   }
 }
 else{
   $field =[
     'message'=>'FAIL',
     'id'=>NULL,
     'nama'=>NULL,
     'email'=>NULL
   ];
   print JSON_ENCODE($field);
 }
}

public function resetpassword($id){
  print "Web Viewnye kang Ye...";
}
public function addjadwal(Request $r){
  $data =[
    'kuota'=>$r->kuota,
    'hari'=>$r->hari,
    'jam_mulai'=>$r->jam_mulai,
    'jam_selesai'=>$r->jam_selesai,
    'id_guru'=>$r->id_guru,
    'id_kategorilayanan'=>$r->idkatlayanan,
    'pertemuan'=>$r->pertemuan,
    'id_kategorimengajar'=>$r->id_katmengajar,
    'tarif'=>$r->tarif
  ];
  $act = Jadwal::insert($data);
  if(!$act){
    $field=[
      'message'=>'FAIL'
    ];
    print JSON_ENCODE($field);
  }else{
    $field=[
      'message'=>'OK'
    ];
    print JSON_ENCODE($field);
  }
}

//Menampilkan List Layanan
public function getdatalayanan(){
$data = Layanan::all();
$result = array();
foreach ($data as $key => $value) {
  array_push($result,array(
    'id'=>$value->id_kategorilayanan,
    'kategorilayanan'=>$value->kategorilayanan
  ));
}
$field = [
  'data'=>$result
];
echo json_encode($field);
}
//Menampilkan List Mengajar
public function getdatamengajar(){
$data = Mengajar::all();
$result = array();
foreach ($data as $key => $value) {
  array_push($result,array(
    'id'=>$value->id_kategorimengajar,
    'kategorimengajar'=>$value->kategorimengajar
  ));
}
echo json_encode(array('data'=>$result));
}

}
