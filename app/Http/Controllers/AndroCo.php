<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Session;
use App\PaketModel;
use App\PegawaiModel;
use App\Pemesananmodel;
use App\JamModel;
use App\Cmenu;
use App\Loginmodel;
use App\UserModel;
use App\Slider;
use App\MenuModel;
use App\AbsenModel;
use App\RouteModel;
use App\KordinatModel;
use App\TblCuti;
use DateTime;
use DatePeriod;
use DateInterval;
use File;
use Helper;
use Intervention\Image\ImageManagerStatic as Image;
class AndroCo extends Controller
{

public function apiandro($key=null,$url=null,Request $r){

  if($key=='RASENGAN'){
    switch ($url) {
      case 'daftarhadir':
      $class = new Cmenu();
      $ki       = substr($r->kode_unitkerja,0,8);
      $data     = $class->getpegawaiinstansi($ki);
      print json_encode($data);
      break;
      case 'listroute':
      $result = array();
      $level  = Session::get('level');
      $data = RouteModel::where('active','Y')
               ->get();
               foreach ($data as $key => $route) {
                 $mn = explode(',',$route->session);

                 //$mn = array("admin", "Joe", "Glenn", "Cleveland");

                   if(in_array($level,$mn)){
                     $dt=[
                       'link'=>$route->link,
                       'controller'=>$route->controller,
                       'method'=>$route->method
                     ];
                      array_push($result,$dt);
                   }



               }
              return json_encode($result);
      break;
      case 'listizin':
      $result = array();
      $data   = AbsenModel::where('id_pegawai',$r->id)->where('status',$r->status)->orderby('id_absen','DESC')->groupby('no_surat')->get();
      if($data->count() > 0){

        $result=[
          'msg'=>'OK',
          'data'=>$data,
        ];
         return json_encode($result);
      }else{
        $result=[
          'msg'=>'FAIL',
          'data'=>null,
        ];
         return json_encode($result);
      }
      break;
      case 'getinfoabsen':
      $jenis = ($r->jenis=='1 Hari') ? 'A':$r->jenis;
      $result= array();
      $check = AbsenModel::where('id_pegawai',$r->id)
      ->where('jenis',$jenis)
                ->where('kode_unitkerja',$r->kode_unitkerja)
                ->wheredate('tglabsen',$r->tgl)
               ->first();

      if($check){
        $result=[
          'status'=>$check->status,
          'latitude'=>$check->latitude,
          'longitude'=>$check->longitude,
          'waktuabsen'=>$check->time,
        ];
        print json_encode($result);
      }else{
        //test
        $result=[
          'status'=>'',
          'latitude'=>'',
          'longitude'=>'',
          'waktuabsen'=>'',
        ];
        print json_encode($result);
      }
        // code...
        break;
      case 'datapegawai':
        $class = new Cmenu();
        $data  = $class->getpegawaiinstansi($r->kode_unitkerja);
        if($data != null){
          return $data;
        }
       break;
      case 'getjam':
        $class = new Cmenu();
        $result = array();
        $hari      = $class->gethari(date('Y-m-d'));

        $kordinat  = KordinatModel::where('kode_unitkerja',$r->id)->first();
        $jammasuk  = JamModel::where('hari',$hari)
                     ->where('kode_unitkerja',$r->id)
                     ->where('jenis','Jam Masuk')
                     ->first();
        $jampulang = JamModel::where('kode_unitkerja',$r->id)->where('hari',$hari)
                     ->where('jenis','Jam Pulang')
                     ->first();
        $masuk     = ($jammasuk != null) ? $jammasuk->jam.' - '.$jammasuk->batas:'LIBUR';
        $pulang    = ($jampulang != null) ? $jampulang->jam.' - '.$jampulang->batas:'LIBUR';
        $result=[
          'latitudekantor'=>$kordinat->latitude,
          'longitudekantor'=>$kordinat->longitude,
          'jam_masuk'=>$masuk,
          'jam_keluar'=>$pulang,
        ];
        print json_encode($result);
        break;

        case 'uploadizin':
        $class      = new Cmenu();
        $unitkerja  = $class->getprofilpgapi($r->id);
        $target_dir = 'suratizin/'.$unitkerja['kode_unitkerja'];
        $dari      = new DateTime($r->awal);
        $tgl2      = date('Y-m-d', strtotime('+1 days', strtotime($r->akhir)));
        $sampai    = new DateTime($tgl2);
        $interval  = DateInterval::createFromDateString('1 day');
        $periode   = new DatePeriod($dari,$interval,$sampai);
        $latitude  = ($r->has('latitude')) ? $r->latitude:'0';
        $longitude = ($r->has('longitude')) ? $r->longitude:'0';
        $sukses    = 0;
        $gagal     = 0;
        $r->validate([
            'file' => 'required|mimes:pdf|max:600',
        ]);

        $fileName  = time().'.'.$r->file->extension();
        $result    = array();
          foreach ($periode as $dt ) {
            $data=[
              'id_absen'=>uniqid(),
              'id_pegawai'=>$r->id,
              'status'=>$r->status,
              'keterangan'=>$r->keterangan,
              'jenis'=>$r->jenis,
              'kode_unitkerja'=>$unitkerja['kode_unitkerja'],
              'no_surat'=>$r->nosurat,
              'latitude'=>$latitude,
              'longitude'=>$longitude,
              'swafoto'=>'izin.png',
              'tglabsen'=>$dt->format('Y-m-d'),
              'file'=>$fileName,
              'masaizin'=>$r->awal.' s/d '.$r->akhir,
            ];
            $act  = AbsenModel::insert($data);
            if($act){
              $sukses+=1;
            }else{
              $gagal+=1;
            }

          }
          if($sukses > 0){
              $r->file->move(public_path($target_dir), $fileName);
              $result =[
                'message'=>'Upload Berhasil',
                'success'=>true
              ];
              print json_encode($result);

          }else{
            $result =[
              'message'=>'fail',
              'success'=>false
            ];
            print json_encode($result);

          }


        break;


      default:
        // code...
        break;

  }

}else{
    $result =[
      'massage'=>'TOKEN INVALID'
    ];
    print json_encode($result);
  }
}


public function getemployee(Request $r){
  try {
    $data = PegawaiModel::where('kode_unitkerja',$r->kode_unitkerja)
            ->where('id','!=',$r->id)
            ->get();
    $d=[
      'message'=>'1',
      'data'=>$data
    ];
    print json_encode($d);
    
  } catch (\Throwable $th) {
    //throw $th;
  }
}

public function login(Request $r){
   try {
    $data = UserModel::where('username',$r->username)->where('password',md5($r->password))->join('tbl_pegawai','tbl_pegawai.id','tbl_user.id_pegawai')->first();
    
    $lokasikantor = KordinatModel::select('latitude','longitude','radius','nama_unitkerja')->where('tbl_kordinat.kode_unitkerja',$data->kode_unitkerja)
    ->join('data_unitkerja','data_unitkerja.kode_unitkerja','tbl_kordinat.kode_unitkerja')->first();
    $hari =  Helper::cekhari();
    $hour = date('H');
    $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
    if($dayTerm=='Morning'){
    $jam = JamModel::where('hari',$hari)->where('kode_unitkerja',$data->kode_unitkerja)->where('jenis','Jam Masuk')->first();
    $checkabsen = AbsenModel::where('id_pegawai',$data->id_pegawai)->where('kode_unitkerja',$data->kode_unitkerja)->where('tglabsen',date('Y-m-d'))->where('jenis','M')->count();
    $checkabsen = ($checkabsen > 0) ? "no":"yes";
  }else if($dayTerm=='Afternoon'){
    $jam = JamModel::where('hari',$hari)->where('kode_unitkerja',$data->kode_unitkerja)->where('jenis','Jam Pulang')->first();
    $checkabsen = AbsenModel::where('id_pegawai',$data->id_pegawai)->where('kode_unitkerja',$data->kode_unitkerja)->where('tglabsen',date('Y-m-d'))->where('jenis','P')->count();
    $checkabsen = ($checkabsen > 0) ? "no":"yes";
    }else{
      $jam = JamModel::where('hari',$hari)->where('kode_unitkerja',$data->kode_unitkerja)->where('jenis','Jam Pulang')->first();
      $checkabsen = "no";
    }
    $absen = AbsenModel::where('id_pegawai',$data->id)->where('kode_unitkerja',$data->kode_unitkerja)->orderby('time','DESC')->get();
    if(!empty($data)){
      return response()->json([
      'message'=>'1',
      'data'=>$data,
      'kantor'=>$lokasikantor,
      'jam'=>($jam != null) ? $jam:$j=['jam'=>'10:00','batas'=>'11:00'],
      'bisaabsen'=>$checkabsen,
      'listabsen'=>$absen
    ]);
   }else{
    return response()->json([
      'message'=>'0',
      'data'=>null
    ]);
   }
   } catch (\Throwable $th) {
    return response()->json([
      'message'=>$th->getmessage(),
      'data'=>null
    ]);
   }
}


public function updatesandi(Request $r){
  $c =  UserModel::where('id_user',$r->id)->count();
  if($c > 0){
    $c =  UserModel::where('id_user',$r->id)->first();
    if($c->password == md5($r->old_password)){
      $p = [
        'password'=>md5($r->password)
      ];
      UserModel::where('id_user',$r->id)->update($p);
      return response()->json([
        'message'=>'Data berhasil diupdate',
      ]);
    }else{
      return response()->json([
        'message'=>'Password Lama salah',
      ]);
    }
  }else{
    return response()->json([
      'message'=>'Akun tidak tersedia',
    ]);
  }
}

//CUTI

function addcuti(Request $request){
  if ($request->hasFile('file')) {
    // Handle file upload as before

    // Handle additional data if needed
    $id = $request->input('id');
    $jenisCuti = $request->input('jenis_cuti');
    $dari = $request->input('dari');
    $sampai = $request->input('sampai');
    $alasan = $request->input('alasan');
    $rentang= $dari.' s/d '.$sampai;

    $class = new Cmenu();
    $pg    = $class->getpegawai($id);

    try {
      $file = $request->file('file');
      $filename = $file->getClientOriginalName();
      
      $data=[
        'jenis_cuti'=>$jenisCuti,
        'rentang_absen'=>$rentang,
        'alasan'=>$alasan,
        'id_instansi'=>$pg->kode_unitkerja,
        'file'=>$filename,
        'id_pegawai'=>$id,
        'status'=>'A',
      ];
      try {
        TblCuti::insert($data);
        $file->move(public_path('uploads'), $filename);
        return response()->json(['message' => 'File uploaded successfully']);
      } catch (\Throwable $th) {
        return response()->json(['message' => $th->getMessage()]);
      }
      
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()]);
    }

    // Return a success response or perform further actions
    
} else {
    // Return an error response
    return response()->json(['message' => 'No file provided'], 400);
}
}
function getcuti($id,$idistansi){
  try {
    $data = TblCuti::where('id_pegawai',$id)
    ->where('id_instansi',$idistansi)
    ->orderBy('created_at','desc')
    ->get();
    $result=[
      'message'=>'1',
      'data'=>$data,
    ];
    print json_encode($result);
  } catch (\Throwable $th) {
    $result=[
      'message'=>'0',
      'data'=>null,
    ];
    print json_encode($result);
  }
}

function deletecuti($id){
  try {
    $file = TblCuti::where('id',$id)->first();
    if(file_exists(public_path('uploads/'.$file->file))){
      unlink(public_path('uploads/'.$file->file));
    }
    TblCuti::where('id',$id)
    ->delete();
    $result=[
      'message'=>'success',
    ];
    print json_encode($result);
   }catch (\Throwable $th) {
    $result=[
      'message'=>$th->getMessage(),
    ];
    print json_encode($result);
  }
}

function updatecutiimage(Request $request){
  if ($request->hasFile('file')) {
    // Handle file upload as before

    // Handle additional data if needed
    $id        = $request->input('id');
    $id_cuti   = $request->input('id_cuti');
    $jenisCuti = $request->input('jenis_cuti');
    $dari      = $request->input('dari');
    $sampai    = $request->input('sampai');
    $alasan    = $request->input('alasan');
    $rentang   = $dari.' s/d '.$sampai;
    $class     = new Cmenu();
    $pg        = $class->getpegawai($id);
    $file      = TblCuti::where('id',$id_cuti)->first();
    if(file_exists(public_path('uploads/'.$file->file))){
      unlink(public_path('uploads/'.$file->file));
    }
    try {
      $file = $request->file('file');
      $filename = $file->getClientOriginalName();
      
      $data=[
        'jenis_cuti'=>$jenisCuti,
        'rentang_absen'=>$rentang,
        'alasan'=>$alasan,
        'id_instansi'=>$pg->kode_unitkerja,
        'file'=>$filename,
        'id_pegawai'=>$id,
        'status'=>'A',
      ];
      try {
        TblCuti::where('id',$id_cuti)->update($data);
        $file->move(public_path('uploads'), $filename);
        return response()->json(['message' => 'File uploaded successfully']);
      } catch (\Throwable $th) {
        return response()->json(['message' => $th->getMessage()]);
      }
      
    } catch (\Throwable $th) {
      return response()->json(['message' => $th->getMessage()]);
    }

    // Return a success response or perform further actions
    
} else {
    // Return an error response
    return response()->json(['message' => 'No file provided'], 400);
}
}

function updatecutinoimage(Request $request){
    $id = $request->input('id');
    $id_cuti = $request->input('id_cuti');
    $jenisCuti = $request->input('jenis_cuti');
    $dari = $request->input('dari');
    $sampai = $request->input('sampai');
    $alasan = $request->input('alasan');
    $rentang= $dari.' s/d '.$sampai;
  try {
    $data=[
      'jenis_cuti'=>$jenisCuti,
      'rentang_absen'=>$rentang,
      'alasan'=>$alasan,
      'id_pegawai'=>$id,
    ];
    TblCuti::where('id',$id_cuti)->update($data);
    $result=[
      'message'=>'Update Berhasil',
    ];
    print json_encode($result);
  } catch (\Throwable $th) {
    $result=[
      'message'=>$th->getMessage(),
    ];
    print json_encode($result);
  }
}


public function addizin(Request $r){
        $unitkerja  = $this->getdataid($r->id);
        $target_dir = 'suratizin/'.$unitkerja['kode_unitkerja'];
        $dari      = new DateTime($r->awal);
        $tgl2      = date('Y-m-d', strtotime('+1 days', strtotime($r->akhir)));
        $sampai    = new DateTime($tgl2);
        $interval  = DateInterval::createFromDateString('1 day');
        $periode   = new DatePeriod($dari,$interval,$sampai);
        $latitude  = ($r->has('latitude')) ? $r->latitude:'0';
        $longitude = ($r->has('longitude')) ? $r->longitude:'0';
        $sukses    = 0;
        $gagal     = 0;
        $r->validate([
            'file' => 'required|mimes:pdf|max:600',
        ]);

        $fileName  = time().'.'.$r->file->extension();
        $result    = array();
          foreach ($periode as $dt ) {
            $data=[
              'id_absen'=>uniqid(),
              'id_pegawai'=>$r->id,
              'status'=>$r->status,
              'keterangan'=>$r->keterangan,
              'jenis'=>$r->jenis,
              'kode_unitkerja'=>$unitkerja['kode_unitkerja'],
              'no_surat'=>$r->nosurat,
              'latitude'=>$latitude,
              'longitude'=>$longitude,
              'swafoto'=>'izin.png',
              'tglabsen'=>$dt->format('Y-m-d'),
              'file'=>$fileName,
              'masaizin'=>$r->awal.' s/d '.$r->akhir,
            ];
            $act  = AbsenModel::insert($data);
            if($act){
              $sukses+=1;
            }else{
              $gagal+=1;
            }

          }
          if($sukses > 0){
              $r->file->move(public_path($target_dir), $fileName);
              $result =[
                'message'=>'1',
                'success'=>true
              ];
              print json_encode($result);

          }else{
            $result =[
              'message'=>'0',
              'success'=>false
            ];
            print json_encode($result);

          }
}


function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


public function addabsen(Request $r){
        $unitkerja  = $this->getdataid($r->id);
        $target_dir = 'swafoto/'.$unitkerja['kode_unitkerja'];
        $latitude  = ($r->has('latitude')) ? $r->latitude:'0';
        $longitude = ($r->has('longitude')) ? $r->longitude:'0';
        $ip = $this->get_client_ip();
         if ($r->swa) {
            $base64Image = explode(";base64,", $r->swa);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
            $imagename = uniqid() . '.'.$imageType;
            $file = $target_dir.'/'.$imagename;
            
        }
       
        $result    = array();
        $data=[
              'id_absen'=>uniqid(),
              'id_pegawai'=>$r->id,
              'status'=>$r->status,
              'keterangan'=>'Hadir',
              'jenis'=>$r->jenis,
              'kode_unitkerja'=>$unitkerja['kode_unitkerja'],
              'no_surat'=>null,
              'latitude'=>$latitude,
              'longitude'=>$longitude,
              'swafoto'=>$imagename,
              'ip'=>$ip,
              'tglabsen'=>date('Y-m-d'),
              'file'=>null,
              'masaizin'=>null,
            ];
            try {
              $act  = AbsenModel::insert($data);
              $path = public_path().'/'.$target_dir;
              if(!File::isDirectory($path)){
                  File::makeDirectory($path, 0777, true, true);
              }   
              file_put_contents($path.'/'.$imagename, $image_base64);
              $result =[
                'message'=>'Absen Berhasil dilakukan',
                'success'=>true
              ];
              print json_encode($result);
            } catch (\Throwable $th) {
              $result =[
                'message'=>$th->getmessage(),
                'success'=>false
              ];
              print json_encode($result);
            }
            

            
}

public function getdatabyId(Request $r){
   try {
    $data = UserModel::where('id_user',$r->id)->join('tbl_pegawai','tbl_pegawai.id','tbl_user.id_pegawai')->first();
    $lokasikantor = KordinatModel::select('latitude','longitude','radius','nama_unitkerja')->where('tbl_kordinat.kode_unitkerja',$data->kode_unitkerja)
    ->join('data_unitkerja','data_unitkerja.kode_unitkerja','tbl_kordinat.kode_unitkerja')->first();
    $hari =  Helper::cekhari();
    $hour = date('H');
    $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
    if($dayTerm=='Morning'){
    $jam = JamModel::where('hari',$hari)->where('kode_unitkerja',$data->kode_unitkerja)->where('jenis','Jam Masuk')->first();
    $checkabsen = AbsenModel::where('id_pegawai',$r->id)->where('kode_unitkerja',$data->kode_unitkerja)->where('tglabsen',date('Y-m-d'))->where('jenis','M')->count();
    $checkabsen = ($checkabsen > 0) ? "no":"yes";
  }else if($dayTerm=='Afternoon'){
    $jam = JamModel::where('hari',$hari)->where('kode_unitkerja',$data->kode_unitkerja)->where('jenis','Jam Pulang')->first();
    $checkabsen = AbsenModel::where('id_pegawai',$r->id)->where('kode_unitkerja',$data->kode_unitkerja)->where('tglabsen',date('Y-m-d'))->where('jenis','P')->count();
    $checkabsen = ($checkabsen > 0) ? "no":"yes";
    }else{
      $jam=null;
      $checkabsen = "no";
    }
    $absen = AbsenModel::where('id_pegawai',$r->id)->where('kode_unitkerja',$data->kode_unitkerja)->orderby('time','DESC')->get();
    if(!empty($data)){
      return response()->json([
      'message'=>'1',
      'data'=>$data,
      'kantor'=>$lokasikantor,
      'jam'=>($jam != null) ? $jam:$j=['jam'=>'10:00','batas'=>'12:00'],
      'bisaabsen'=>$checkabsen,
      'listabsen'=>$absen
    ]);
   }else{
    return response()->json([
      'message'=>'0',
      'data'=>null
    ]);
   }
   } catch (\Throwable $th) {
    return response()->json([
      'message'=>$th->getmessage(),
      'data'=>null
    ]);
   }

}


public function getdataid($id){
   try {
    $data = UserModel::where('id_user',$id)->first();
    return $data; 
   } catch (\Throwable $th) {
    return response()->json([
      'message'=>$th->getmessage(),
      
    ]);
   }

}



public function updateprofile(Request $r){
  try {
    $data = [
      'nama'=>$r->nama,
      'email'=>$r->email,
      'nohp'=>$r->nohp,
      'alamat'=>$r->alamat,
    ];
    $act = UserModel::where('id_user',$r->id)->update(
      $data
    );
      if($r->foto !='kosong'){
            $base64Image  = explode(";base64,", $r->foto);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType    = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);
            $imagename    = uniqid() . '.'.$imageType;
            $target_dir   = 'pegawai/'.$r->kode_unitkerja;
            $pg = [
              'nama'=>$r->nama,
              'email'=>$r->email,
              'image'=>$imagename,
              'nohp'=>$r->nohp,
            ];
      }else{
        $pg = [
          'nama'=>$r->nama,
          'email'=>$r->email,
          'nohp'=>$r->nohp,
        ];
      }
       $update_pg = PegawaiModel::where('id',$r->id_pegawai)->update($pg);
        if($update_pg){
          if($r->foto !=='kosong'){
            try {
              $path = public_path().'/'.$target_dir;
              if(!File::isDirectory($path)){
                  File::makeDirectory($path, 0777, true, true);
              }   
              file_put_contents($path.'/'.$imagename, $image_base64);
              return response()->json([
                'message'=>'Data berhasil diupdate',
              ]);
            } catch (\Throwable $th) {
              return response()->json([
                'message'=>$th->getMessage(),
              ]);
            }
           
          }else{
            return response()->json([
              'message'=>'Data berhasil diupdate',
            ]);
          }
         
        }
     
    
  } catch (\Throwable $th) {
    return response()->json([
      'message'=>'Data berhasil diupdate',
    ]);
  }
}




     }
