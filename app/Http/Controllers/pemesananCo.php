<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\level;
use App\Loginmodel;
use App\Mengajar;
use App\Pemesananmodel;

use App\aksesmenuModel;
class pemesananCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_pemesanan";
  $this->main    = "theme.pemesanan";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = Pemesananmodel::where('id_pengusaha',Session::get('id_user'))
           ->join('tbl_user','tbl_user.id_user','tbl_pemesanan.id_user')
           ->get();
  return view($this->index,['data'=>$data]);
}
public function save(Request $r){
  $data=[
    'kategorimengajar'=>$r->kategori
  ];
  $act = Mengajar::insert($data);
  return back()->with('success',$this->msukses);
}
public function terimapesan(Request $r){
  $data=[
    'status'=>'Y'
  ];
  $act = Pemesananmodel::where($this->primary,base64_decode($r->id))->update($data);
  return back()->with('success',$this->msukses);
}
public function update(Request $r){
  $data=[
    'kategorimengajar'=>$r->kategori
  ];
  $act = Mengajar::where($this->primary,$r->id)->update($data);
  return back()->with('success',$this->msukses);
}

public function hapus($id=null){
  $act = Mengajar::where($this->primary,base64_decode($id))->delete();
  return back()->with('success','Data Berhasil di hapus');
}
public function blokir($id=null){
  $data =[
    'blokir'=>'Y'
  ];
  $act = Mengajar::where($this->primary,base64_decode($id))->update($data);
  return back()->with('success','Akun Berhasil di blokir');
}
public function buka($id=null){
  $data =[
    'blokir'=>'N'
  ];
  $act = Mengajar::where($this->primary,base64_decode($id))->update($data);
  return back()->with('success','Akun berhasil di unblokir');
}
public function reset($id=null){
  $data=[
    'password'=>md5('12345')
  ];
  $act = Loginmodel::where($this->primary,base64_decode($id))->update($data);
  return back()->with('success','Password Berhasil di reset');
}




     }
