<?php
namespace App\Http\Controllers\instansi;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\Level;
use App\galerymodel;
use App\aksesmenuModel;
use App\KordinatModel;
use App\AbsenModel;
use App\PegawaiModel;
use App\UserModel;
use App\Cmenu;
use App\LuarkantorModel;
use DateTime;
use DatePeriod;
use DateInterval;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
class AbsensiCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_absensi";
  $this->main    = "theme.absensi";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  /*$class    = new Cmenu();
  
  $data     = $class->getpegawaiinstansi($ki);*/
  $ki       = substr(Session::get('kode_unitkerja'),0,8);
  $pg       = PegawaiModel::where('kode_unitkerja','LIKE','%'.$ki.'%')->get();
  return view($this->index,compact('pg'));
}

public function cetakabsensi(Request $r){
  $class = new Cmenu();
  if(Session::get('level')=='user'){
    $dataabsen    = array();
    $ki       = substr(Session::get('kode_unitkerja'),0,8);
    $pg       = PegawaiModel::where('kode_unitkerja','LIKE','%'.$ki.'%')->get();
    $start    = $r->from;
    $end      = $r->to;
    $implodedate = [$start, $end];
    foreach($pg as $i => $v){
      $H       = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->whereBetween('tglabsen', $implodedate)->where('status','H')->count();
      $D       = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->whereBetween('tglabsen', $implodedate)->where('status','D')->count();
      $C       = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->whereBetween('tglabsen', $implodedate)->where('status','C')->count();
      $S       = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->whereBetween('tglabsen', $implodedate)->where('status','S')->count();
      $A       = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->whereBetween('tglabsen', $implodedate)->where('status','A')->count();
      $P       = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->whereBetween('tglabsen', $implodedate)->where('status','P')->count();
      $data =[
        'no'=>$i+1,
        'nama_pegawai'=>((empty($v->gd) OR $v->gd == '-') ? '':$v->gd).''.$v->nama.' '.$v->gb,
        'nip'=>$v->nip,
        'pangkat'=>$v->pangkat_gol,
        'H'=>($H > 0 ) ? ($H/2):"-",
        'D'=>($D > 0 ) ? ($D/2):"-",
        'C'=>($C > 0 ) ? ($C/2):"-",
        'S'=>($S > 0 ) ? ($C/2):"-",
        'A'=>($A > 0 ) ? ($A/2):"-",
        'P'=>($P > 0 ) ? ($P/2):"-",
      ];
      array_push($dataabsen,$data);
    }
    $date = $class->tgl_indos($start).' - '.$class->tgl_indos($end);
    $instansi = $class->namainstansi(Session::get('kode_unitkerja'));
    // return view('theme.laporan.absensi',compact('dataabsen','instansi','date'));
    $pdf = PDF::loadview('theme.laporan.absensi',compact('dataabsen','instansi','date'));
	  return $pdf->stream();
  }else if(Session::get('level')=='BKPP'){
    print "BKPP";
  }else{
    print "NOTFOUND";
  }
}
public function laporan(){
  $class       = new Cmenu();
  $skpd = $listintansi = (object) $class->listinstansi();
  return view($this->main.'.laporan',compact('skpd'));
}
public function save(Request $r){
  if($r->file('file')) {
    $r->validate([
       'file' => 'required|mimes:png,jpg,jpeg|max:2048'
    ]);
        $file = $r->file('file');
        $ext  = $file->getClientOriginalExtension();
        $name = time().'.'.$ext;
        $image_resize = Image::make($file->getRealPath());
        $image_resize->resize(800, 600);
        $image_resize->save(public_path('theme/galery/'.$name));
        $data=[
          'judul'=>$r->judul,
          'file'=>$name
        ];
        $act = galerymodel::insert($data);
        return back()->with('success',$this->msukses);
   }

}

public function updateabsensi(Request $r){
  try {
    $data=[
      'status'=>$r->aksi
    ];
    AbsenModel::where('id_absen',$r->id)->update($data);
    return back();
  } catch (\Throwable $th) {
    //throw $th;
  }
}
public function ajukanizin(Request $r){
  $pg        = $r->pg;
  $file      = $r->file('file');
  $namefile  = $file->getClientOriginalName();
  $latitude  = ($r->has('latitude')) ? $r->latitude:'0';
  $longitude = ($r->has('longitude')) ? $r->longitude:'0';
  $destinationPath = 'suratizin/'.Session::get('kode_unitkerja').'/';
  $file->move($destinationPath,$namefile);
  $dari      = new DateTime($r->awal);
  $tgl2      = date('Y-m-d', strtotime('+1 days', strtotime($r->akhir)));
  $sampai    = new DateTime($tgl2);
  $interval  = DateInterval::createFromDateString('1 day');
  $periode   = new DatePeriod($dari,$interval,$sampai);
  foreach ($pg as $p) {
    foreach ($periode as $dt ) {
      $data=[
        'id_absen'=>uniqid(),
        'id_pegawai'=>$p,
        'status'=>$r->jenis,
        'jenis'=>$r->kat,
        'no_surat'=>$r->nosurat,
        'latitude'=>$latitude,
        'longitude'=>$latitude,
        'swafoto'=>'dinas.png',
        'tglabsen'=>$dt->format('Y-m-d'),
        'file'=>$namefile,
      ];
      $act  = AbsenModel::insert($data);
    }

  }
  return back()->with('success','Data berhasil disimpan');

}
public function update(Request $r){
  if($r->file('file')) {
    $r->validate([
       'file' => 'required|mimes:png,jpg,jpeg|max:2048'
    ]);
        $file = $r->file('file');
        $ext  = $file->getClientOriginalExtension();
        $name = time().'.'.$ext;
        $image_resize = Image::make($file->getRealPath());
        $image_resize->resize(800, 600);
        $image_resize->save(public_path('theme/galery/'.$name));
        if($r->logold != 'admin.png'){
        if(file_exists(public_path('theme/galery/'.$r->logold)))
        {
        unlink(public_path('theme/galery/'.$r->logold));
        }
        }
        $data=[
          'judul'=>$r->judul,
          'file'=>$name
        ];
        $act = galerymodel::where('id_galery',$r->id)->update($data);
        return back()->with('success',$this->msukses);
   }else{
     $data=[
       'judul'=>$r->judul
     ];
     $act = galerymodel::where('id_galery',$r->id)->update($data);
     return back()->with('success',$this->msukses);
   }
}
public function resetabsensi($id=null){
  try {
     AbsenModel::where('id_absen',$id)->delete();
     return back()->with('success','Data berhasil direset');
  } catch (\Throwable $th) {
    return back()->with('danger',$th->getmessage());
  }
}
public function absenluarkantor(Request $r){
  $data = LuarkantorModel::all();
  return view('theme.absensi.luarkantor',compact('data'));
}
public function absenmanualsave(Request $r){
  $publicKeyContents = Storage::get('encription/public_key.pem');
  $publicKey = openssl_pkey_get_public($publicKeyContents);
  if (openssl_public_encrypt($data, $encrypted, $publicKey)) {
    $encryptedData = base64_encode($encrypted);
    $data =[
      'nama_tempat'=>$r->tempat,
      'start'=>$r->start,
      'end'=>$r->end,
      'latitude'=>$r->latitude,
      'longitude'=>$r->longitude,
      'radius'=>$r->radius,
      'id_user'=>Session::get('id_user'),
      'qr_code'=>$encryptedData,
     ];
     try {
       LuarKantorModel::insert($data);
       return back()->with('success','Data berhasil disimpan');
     } catch (\Throwable $th) {
       return back()->with('danger',$th->getMessage());
     }
  }else{
      
  }
   
}

public function absenmanualupdate(Request $r){
  $data =[
    'nama_tempat'=>$r->tempat,
    'start'=>$r->start,
    'end'=>$r->end,
    'latitude'=>$r->latitude,
    'longitude'=>$r->longitude,
    'radius'=>$r->radius,
    'id_user'=>Session::get('id_user'),
    'qr_code'=>Str::uuid()->toString(),
   ];
   try {
     LuarKantorModel::where('id_luarkantor',$r->id)->update($data);
     return back()->with('success','Data berhasil diupdate');
   } catch (\Throwable $th) {
    return back()->with('danger',$th->getMessage());
   }
}
public function hapusluarkantor($id){
  try {
    LuarKantorModel::where('id_luarkantor',base64_decode($id))->delete();
    return back()->with('success','Data berhasil dihapus');
  } catch (\Throwable $th) {
    return back()->with('danger',$th->getMessage());
  }
}
public function absenmanual(Request $r){
   $checkuser = UserModel::where('id_pegawai',$r->id)->count();
   if($checkuser > 0){
    $user = UserModel::where('id_pegawai',$r->id)->first();
    $keterangan = ($r->status=='A')?'Tanpa Keterangan':'Hadir (ABSEN MANUAL)';
    $keterangan = ($r->status=='C')?'Cuti':$keterangan;
    $keterangan = ($r->status=='S')?'Sakit':$keterangan;
    $keterangan = ($r->status=='P')?'Pendidikan':$keterangan;
    $keterangan = ($r->status=='D')?'Dinas':$keterangan;
    $ip = $this->get_client_ip();
    $data=[
      'id_absen'=>uniqid(),
      'id_pegawai'=>$user->id_user,
      'kode_unitkerja'=>$user->kode_unitkerja,
      'status'=>$r->status,
      'keterangan'=>$keterangan,
      'jenis'=>$r->jenis,
      'latitude'=>'',
      'longitude'=>'',
      'swafoto'=>'absenmanual.png',
      'ip'=>$ip,
      'tglabsen'=>date('Y-m-d'),
      'tglabsen'=>date('Y-m-d'),
    ];
    try {
      AbsenModel::insert($data);
      return back()->with('success','Data berhasil diupdate');
    } catch (\Throwable $th) {
      return back()->with('danger',$th->getmessage());
    }
   }else{
    return back()->with('danger','Pegawai bersangkutan belum mempunyai akun harap buat terlebih dahulu akun nya');
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

public function hapus($id=null){
  $check = galerymodel::where('id_galery',base64_decode($id))->count();
  if($check > 0){
    $act = galerymodel::where($this->primary,base64_decode($id))->delete();
    return back()->with('success','Data berhasil dihapus');
  }else{
    return back()->with('danger','Data tidak tersedia');
  }

}


public function apiabsen(Request $r){
  if(Session::get('level')=='BKPP'){
    $ki       = substr($r->skpd,0,8);
    $pg       = PegawaiModel::where('kode_unitkerja','LIKE','%'.$ki.'%')->get();
    $viewabsen= 'laporanabsensi';
  }else{
    $ki       = substr(Session::get('kode_unitkerja'),0,8);
    $pg       = PegawaiModel::where('kode_unitkerja','LIKE','%'.$ki.'%')->get();
    $viewabsen= 'dataabsensi';
  }
  $array    = array();
  foreach($pg as $i => $v){
    $absensi = AbsenModel::where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->where('tglabsen',date('Y-m-d'))->first();
    $data =[
      'no'=>$i+1,
      'nama_pegawai'=>((empty($v->gd) OR $v->gd == '-') ? '':$v->gd).''.$v->nama.' '.$v->gb,
      'pangkat'=>$v->pangkat_gol,
      'waktu_absen'=>(!empty($absensi->tglabsen)) ? $absensi->tglabsen:"Belum Absen",
      'H'=>(!empty($absensi->status)) ? ($absensi->status=='H') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'D'=>(!empty($absensi->status)) ? ($absensi->status=='D') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'C'=>(!empty($absensi->status)) ? ($absensi->status=='C') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'S'=>(!empty($absensi->status)) ? ($absensi->status=='S') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'A'=>(!empty($absensi->status)) ? ($absensi->status=='A') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'P'=>(!empty($absensi->status)) ? ($absensi->status=='P') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      // 'aksi'=>(!empty($absensi->status)) ? '<a href="'.url($viewabsen.'?view='.$absensi->id_absen).'" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-image"></i></a>':'<img style="width:30px" src="'.asset('load.gif').'"> <a style="color:white" class="btn btn-primary btn-sm">Manual</a>',
      'aksi'=> (!empty($absensi->status)) ? '<a href="'.url($viewabsen.'?view='.$absensi->id_absen).'" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-image"></i></a>
      <a onclick="reset(\'' . htmlspecialchars($absensi->id_absen, ENT_QUOTES) . '\')" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i></a>':'<a data-toggle="modal" data-target="#absen'.$v->id.'" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i> Manual</a>
      <div id="absen'.$v->id.'" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Absensi Secara Manual</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form action="'.url('manualabsen').'" method="POST">
          <input type="hidden" value="'.$v->id.'" name="id" required>
          <div class="modal-body">
            <p>Perhatian. Fitur ini hanya digunakan apabila terjadi kendala saat melakukan proses absensi menggunakan Aplikasi atau ada kemungkinan hal yang tidak bisa di lakukan menggunakan Aplikasi Mobile</p>
            <label>Status Absensi yang diberikan kepada <span style="font-weight:bold">'.((empty($v->gd) OR $v->gd == '-') ? '':$v->gd).''.$v->nama.' '.$v->gb.'</span> :</label>
            <select class="form-control" name="status" required>
              <option value="H">Hadir</option>
              <option value="S">Sakit</option>
              <option value="D">Dinas</option>
              <option value="C">Cuti</option>
              <option value="P">Pendidikan</option>
              <option value="A">Tanpa Keterangan</option>
            </select>
            <label>Jenis Absensi</label>
            <select class="form-control" name="jenis" required>
              <option value="M">Absen Masuk</option>
              <option value="P">Absen Pulang</option>
            </select>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
          </div>
          </form>
        </div>
    
      </div>
    </div>',
    ];
    array_push($array,$data);
  }
  $datajson = [
  "draw"=> 1,
  "recordsTotal"=> count($pg),
  "recordsFiltered"=> count($pg), 
  "data"=>$array
  ];
  print json_encode($datajson);

}

public function getdataabsenfromjenis(Request $r){
  $array    = array();
  if(Session::get('level')=='BKPP'){
    $ki       = substr($r->skpd,0,8);
    $pg       = PegawaiModel::where('kode_unitkerja','LIKE','%'.$ki.'%')->get();
    $viewabsen= 'laporanabsensi';
  }else{
    $ki       = substr(Session::get('kode_unitkerja'),0,8);
    $pg       = PegawaiModel::where('kode_unitkerja','LIKE','%'.$ki.'%')->get();
    $viewabsen= 'dataabsensi';
  }
  foreach($pg as $i => $v){
    $absensi = AbsenModel::where('jenis',$r->jenisabsen)->where('tbl_user.id_pegawai',$v->id)->join('tbl_user','tbl_user.id_user','tbl_absen.id_pegawai')->where('tglabsen',$r->tanggalabsen)->first();
    $data =[
      'no'=>$i+1,
      'nama_pegawai'=>((empty($v->gd) OR $v->gd == '-') ? '':$v->gd).''.$v->nama.' '.$v->gb,
      'pangkat'=>$v->pangkat_gol,
      'waktu_absen'=>(!empty($absensi->tglabsen)) ? $absensi->tglabsen:"Belum Absen",
      'H'=>(!empty($absensi->status)) ? ($absensi->status=='H') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'D'=>(!empty($absensi->status)) ? ($absensi->status=='D') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'C'=>(!empty($absensi->status)) ? ($absensi->status=='C') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'S'=>(!empty($absensi->status)) ? ($absensi->status=='S') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'A'=>(!empty($absensi->status)) ? ($absensi->status=='A') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'P'=>(!empty($absensi->status)) ? ($absensi->status=='P') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'aksi'=> (!empty($absensi->status)) ? '<a href="'.url($viewabsen.'?view='.$absensi->id_absen).'" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-image"></i></a>
      <a onclick="reset(\'' . htmlspecialchars($absensi->id_absen, ENT_QUOTES) . '\')" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i></a>':'<a data-toggle="modal" data-target="#absen'.$v->id.'" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i> Manual</a>
      <div id="absen'.$v->id.'" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Absensi Secara Manual</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form action="'.url('manualabsen').'" method="POST">
          <input type="hidden" value="'.$v->id.'" name="id" required>
          <div class="modal-body">
            <p>Perhatian. Fitur ini hanya digunakan apabila terjadi kendala saat melakukan proses absensi menggunakan Aplikasi atau ada kemungkinan hal yang tidak bisa di lakukan menggunakan Aplikasi Mobile</p>
            <label>Status Absensi yang diberikan kepada <span style="font-weight:bold">'.((empty($v->gd) OR $v->gd == '-') ? '':$v->gd).''.$v->nama.' '.$v->gb.'</span> :</label>
            <select class="form-control" name="status" required>
              <option value="H">Hadir</option>
              <option value="S">Sakit</option>
              <option value="D">Dinas</option>
              <option value="C">Cuti</option>
              <option value="P">Pendidikan</option>
              <option value="A">Tanpa Keterangan</option>
            </select>
            <label>Jenis Absensi</label>
            <select class="form-control" name="jenis" required>
              <option value="M">Absen Masuk</option>
              <option value="P">Absen Pulang</option>
            </select>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
          </div>
          </form>
        </div>
    
      </div>
    </div>',
    ];
    array_push($array,$data);
  }
  $datajson = [
  "draw"=> 1,
  "recordsTotal"=> count($pg),
  "recordsFiltered"=> count($pg), 
  "data"=>$array
  ];
  print json_encode($datajson);
}


     }
