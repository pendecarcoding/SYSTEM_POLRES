<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\Level;
use App\aksesmenuModel;
class aksesmenuCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_akses";
  $this->main    = "theme.aksesmenu";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = level::leftjoin('aksesmenu','aksesmenu.level','level.level')->get();
  $menu  = menu::all();
  return view($this->index,compact('data','menu'));
}
public function save(Request $r){
  $akses = $r->akses;
  $implode = implode(",",$akses);
  $datai=[
    'id_user'=>$r->id,
    'id_menu'=>$implode
  ];
  $act = aksesmenuModel::insert($datai);
  return back()->with('success',$this->msukses);
}
public function update(Request $r){
  $akses = $r->akses;
  $implode = implode(",",$akses);
  $data=[
    'id_menu'=>$implode
  ];
  $act = aksesmenuModel::where($this->primary,$r->id)->update($data);
  return back()->with('success',$this->msupdate);
}




     }
