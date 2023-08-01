<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use App\Pegawaimodel;
use Session;
use App\RouteModel;
use App\JamModel;
use App\Cmenu;
class JamCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_jam";
  $this->main    = "theme.jam";
  $this->index   = $this->main.".index";

}

 public function index(){
   $class = new Cmenu();
   $ki       = Session::get('kode_unitkerja');
   $data     = JamModel::where('kode_unitkerja',$ki)->get();
   return view($this->index,compact('data','ki'));
 }

 public function addjamkerja(Request $r){
   $c = JamModel::where('hari',$r->hari)->where('jenis',$r->jenis)
          ->where('kode_unitkerja',Session::get('kode_unitkerja'))
          ->count();
   if($c > 0){
     $data=[
       'kode_unitkerja'=> Session::get('kode_unitkerja'),
       'jenis'=> $r->jenis,
       'hari'=> $r->hari,
       'jam'=> $r->jam,
       'batas'=> $r->batasabsen,
     ];
     $act = JamModel::where('hari',$r->hari)
            ->where('jenis',$r->jenis)
            ->where('kode_unitkerja',Session::get('kode_unitkerja'))
            ->update($data);
     if($act){
       return back()->with('success','Data berhasil disimpan');
     }else{
       return back()->with('success','Data tidak berhasil disimpan');
     }
   }else{
     $data=[
       'kode_unitkerja'=> Session::get('kode_unitkerja'),
       'jenis'=> $r->jenis,
       'hari'=> $r->hari,
       'jam'=> $r->jam,
       'batas'=> $r->batasabsen,
     ];
     $act = JamModel::insert($data);
     if($act){
       return back()->with('success','Data berhasil disimpan');
     }else{
       return back()->with('success','Data tidak berhasil disimpan');
     }
   }

 }

 public function add(Request $r){
   $data=[
     'nip'=>$r->nip,
     'nama_pegawai'=>$r->nama,
     'tempat_lahir'=>$r->tempatlahir,
     'tgl_lahir'=>$r->tgllahir,
     'jk'=>$r->jk,
     'masa_kerja_tahun'=>$r->tahun,
     'masa_kerja_bulan'=>$r->bulan
   ];
   $act = Pegawaimodel::insert($data);
   return back();
 }

 public function update(Request $r){
   $data=[
     'nip'=>$r->nip,
     'nama_pegawai'=>$r->nama,
     'tempat_lahir'=>$r->tempatlahir,
     'tgl_lahir'=>$r->tgllahir,
     'jk'=>$r->jk,
     'masa_kerja_tahun'=>$r->tahun,
     'masa_kerja_bulan'=>$r->bulan
   ];
   $act = Pegawaimodel::where($this->primary,$r->id)->update($data);
   return back();
 }
 public function hapus($id=null){
   $act = Pegawaimodel::where($this->primary,base64_decode($id))->delete();
   return back();
 }



     }
