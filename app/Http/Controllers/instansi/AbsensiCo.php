<?php
namespace App\Http\Controllers\instansi;
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
use App\Cmenu;
use DateTime;
use DatePeriod;
use DateInterval;
use PDF;
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
      'pangkat'=>'',
      'waktu_absen'=>(!empty($absensi->tglabsen)) ? $absensi->tglabsen:"Belum Absen",
      'H'=>(!empty($absensi->status)) ? ($absensi->status=='H') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'D'=>(!empty($absensi->status)) ? ($absensi->status=='D') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'C'=>(!empty($absensi->status)) ? ($absensi->status=='C') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'S'=>(!empty($absensi->status)) ? ($absensi->status=='S') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'A'=>(!empty($absensi->status)) ? ($absensi->status=='A') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'P'=>(!empty($absensi->status)) ? ($absensi->status=='P') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'aksi'=>(!empty($absensi->status)) ? '<a href="'.url($viewabsen.'?view='.$absensi->id_absen).'" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-image"></i></a>':'<img style="width:30px" src="'.asset('load.gif').'">',
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
      'pangkat'=>'',
      'waktu_absen'=>(!empty($absensi->tglabsen)) ? $absensi->tglabsen:"Belum Absen",
      'H'=>(!empty($absensi->status)) ? ($absensi->status=='H') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'D'=>(!empty($absensi->status)) ? ($absensi->status=='D') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'C'=>(!empty($absensi->status)) ? ($absensi->status=='C') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'S'=>(!empty($absensi->status)) ? ($absensi->status=='S') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'A'=>(!empty($absensi->status)) ? ($absensi->status=='A') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'P'=>(!empty($absensi->status)) ? ($absensi->status=='P') ? '<i style="color:green" class="fa fa-check"></i>':"-" :"-",
      'aksi'=>(!empty($absensi->status)) ? '<a href="'.url($viewabsen.'?view='.$absensi->id_absen).'" style="color:white" class="btn btn-primary btn-sm"><i class="fa fa-image"></i></a>':'<img style="width:30px" src="'.asset('load.gif').'">',
    
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
