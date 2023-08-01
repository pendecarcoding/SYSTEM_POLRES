<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\MenuMakananModel;
use App\level;
use App\Loginmodel;
use App\Gurumodel;
use App\PaketModel;
use App\menuma;
use App\aksesmenuModel;
use Intervention\Image\ImageManagerStatic as Image;
class PaketCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_paket";
  $this->main    = "theme.paket";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  $menu  = MenuMakananModel::where('id_user',Session::get('id_user'))->get();
  $data  = PaketModel::where('id_user',Session::get('id_user'))
           ->orderby('id_paket','DESC')
           ->get();
  return view($this->index,compact('data','menu'));
}
public function save(Request $r){
  $images  = array();
  $files = $r->file('fileUpload');
  if (!empty($_FILES)) {
    foreach ($files as $file) {
      $name = $file->getClientOriginalName();
      $file->move(public_path('theme/paket/'),$name);
      $images[]=$name;
    }


  $data=[
    'gambar'=>implode(',',$images),
    'namapaket'=>$r->namapaket,
    'daftarmenu'=>implode(',',$r->menu),
    'harga'=>$r->harga,
    'id_user'=>Session::get('id_user')
  ];
  $act = PaketModel::insert($data);
  return redirect('datapaket')->with('success','Data berhasil disimpan');
}
}
public function update(Request $r){
  $images  = array();
  if ($r->file('fileUpload')) {
    $files = $r->file('fileUpload');
    foreach ($files as $file) {
      $name = $file->getClientOriginalName();
      $file->move(public_path('theme/paket/'),$name);
      $images[]=$name;
    }


  $data=[
    'gambar'=>implode(',',$images),
    'namapaket'=>$r->namapaket,
    'daftarmenu'=>implode(',',$r->menu),
    'harga'=>$r->harga,
    'id_user'=>Session::get('id_user')
  ];
  $act = PaketModel::where('id_paket',$r->id)->update($data);
  return redirect('datapaket')->with('success','Data berhasil diupdate');
}else{
  $data=[
    'namapaket'=>$r->namapaket,
    'daftarmenu'=>implode(',',$r->menu),
    'harga'=>$r->harga,
    'id_user'=>Session::get('id_user')
  ];
  $act = PaketModel::where('id_paket',$r->id)->update($data);
  return redirect('datapaket')->with('success','Data berhasil diupdate');
}
}

public function hapus($id=null){
  $act = PaketModel::where($this->primary,base64_decode($id))->delete();
  return back()->with('success','Data Berhasil di hapus');
}




     }
