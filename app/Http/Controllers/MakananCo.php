<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\level;
use App\Loginmodel;
use App\MenuMakananModel;
use App\Gurumodel;
use App\aksesmenuModel;
class MakananCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_menumakanan";
  $this->main    = "theme.makanan";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = MenuMakananModel::where('id_user',Session::get('id_user'))
           ->orderby('id_menumakanan','DESC')
           ->get();
  return view($this->index,['data'=>$data]);
}
public function save(Request $r){
  $data=[
    'menumakanan'=>$r->menumakanan,
    'id_user'=>Session::get('id_user'),
  ];
  $act = MenuMakananModel::insert($data);
  return back()->with('success',$this->msukses);
}
public function update(Request $r){
  $check = MenuMakananModel::where($this->primary,$r->id)->count();
  if($check > 0){
    $data=[
      'menumakanan'=>$r->menumakanan,
      'id_user'=>Session::get('id_user'),
    ];
    $act = MenuMakananModel::where($this->primary,$r->id)->update($data);
    return back()->with('success',$this->msukses);
  }else{
    return back()->with('danger','Data tidak tersedia');

  }

}

public function hapus($id=null){
  $check = MenuMakananModel::where($this->primary,base64_decode($id))->count();
  if($check > 0){
    $act = MenuMakananModel::where($this->primary,base64_decode($id))->delete();
    return back()->with('success','Data Berhasil di hapus');
  }else{
    return back()->with('danger','Data tidak tersedia');
  }

}
public function blokir($id=null){
  $data =[
    'blokir'=>'Y'
  ];
  $act = Gurumodel::where($this->primary,base64_decode($id))->update($data);
  return back()->with('success','Akun Berhasil di blokir');
}
public function buka($id=null){
  $data =[
    'blokir'=>'N'
  ];
  $act = Gurumodel::where($this->primary,base64_decode($id))->update($data);
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
