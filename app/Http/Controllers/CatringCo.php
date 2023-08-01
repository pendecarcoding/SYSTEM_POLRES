<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\level;
use App\Loginmodel;
use App\Gurumodel;
use App\PengusahaModel;
use App\aksesmenuModel;
class CatringCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_user";
  $this->main    = "theme.catering";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function daftarpemilikusaha(Request $r){
  if($r->password == $r->ulangipassword){
    $data = [
      'nama'=>$r->nama,
      'nohp'=>$r->nohp,
      'alamat'=>$r->alamat,
      'email'=>$r->email,
      'username'=>$r->username,
      'level'=>'Pengusaha',
      'password'=>md5($r->password),
    ];
    $act = Loginmodel::insertGetId($data);
    $data=[
      'namausaha'=>$r->namausaha,
      'alamatusaha'=>$r->alamatusaha,
      'id_user'=>$act,
    ];
    $act  = PengusahaModel::insert($data);
    return back()->with('success','Pendaftaran berhasil');


  }else{
    return back()->with('danger','Password tidak sama');
  }

}

public function index(){
  $data  = Loginmodel::where('level','Pengusaha')->get();
  return view($this->index,['data'=>$data]);
}
public function save(Request $r){
  $data=[
    'nama'=>$r->nama,
    'username'=>$r->username,
    'password'=>md5($r->pass),
    'level'=>$r->level
  ];
  $act = Loginmodel::insert($data);
  return back()->with('success',$this->msukses);
}
public function update(Request $r){
  $data=[
    'nama'=>$r->nama,
    'username'=>$r->username,
    'alamat'=>$r->alamat,
    'email'=>$r->email,
    'nohp'=>$r->nohp,
    'password'=>md5($r->pass),
    'level'=>$r->level
  ];
  $act = Loginmodel::where($this->primary,$r->id)->update($data);
  return back()->with('success',$this->msukses);
}

public function hapus($id=null){
  $act = Gurumodel::where($this->primary,base64_decode($id))->delete();
  return back()->with('success','Data Berhasil di hapus');
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
