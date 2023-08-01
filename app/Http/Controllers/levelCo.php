<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\level;
use App\aksesmenuModel;
class levelCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_level";
  $this->main    = "theme.level";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = level::all();
  $menu  = menu::all();
  return view($this->index,compact('data','menu'));
}
public function save(Request $r){
  $data=[
    'level'=>$r->level
  ];
  $act = level::insert($data);
  if($act){
    $data=[
      'level'=>$r->level,
      'id_menu'=>'4,9,10,34',
    ];
    $act = aksesmenuModel::insert($data);
    if($act){
      return back()->with('success',$this->msukses);
    }else{
      return back()->with('danger','Data Berhasil disimpan');
    }
  }else{
    return back()->with('danger','Data Berhasil disimpan');
  }

}
public function update(Request $r){
  $check = level::where('id_level',$r->id)->count();
  if($check > 0){
  $data=[
    'level'=>$r->level
  ];
  $act = level::where($this->primary,$r->id)->update($data);
  return back()->with('success',$this->msupdate);
}else{
  return back()->with('danger','Data tidak tersedia');
}
}

public function hapus($id=null){
  $check = level::where('id_level',base64_decode($id))->count();
  if($check > 0){
    $act = level::where($this->primary,base64_decode($id))->delete();
    return back()->with('success','Data berhasil dihapus');
  }else{
    return back()->with('danger','Data tidak tersedia');
  }

}


     }
