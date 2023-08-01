<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use App\Pegawaimodel;
use Session;
use App\RouteModel;
use App\KordinatModel;
use App\Cmenu;
class KordinatCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_kordinat";
  $this->main    = "theme.kordinat";
  $this->index   = $this->main.".index";

}

 public function index(){
   $class       = new Cmenu();
   $data        = KordinatModel::all();
   $listintansi = (object) $class->listinstansi();
   return view($this->index,compact('data','listintansi'));
 }

 public function add(Request $r){
   if($r->id_kordinat=='null'){
     $data=[
       'kode_unitkerja'=>$r->kode_unitkerja,
       'latitude'=>$r->latitude,
       'longitude'=>$r->longitude,       
     	'id_user'=>Session::get('id_user'),
        'radius'=>$r->radius
     ];
     $act = KordinatModel::insert($data);
     return back()->with('success','Data berhasil disimpan');
   }else{


     $data=[
       'kode_unitkerja'=>$r->kode_unitkerja,
       'latitude'=>$r->latitude,
       'longitude'=>$r->longitude,
	    'id_user'=>Session::get('id_user'),
       'radius'=>$r->radius
     ];
     $act = KordinatModel::where('id_kordinat',$r->id_kordinat)->update($data);
     return back()->with('success','Data berhasil diupdate');
   }


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
