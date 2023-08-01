<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\Level;
class sidemenuCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_side";
  $this->main    = "theme.menu";
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = menu::orderBy('sortby','ASC')->get();
  $sub   = menu::orderBy('sortby','ASC')->get();
  $level = level::all();
  return view($this->index,compact('data','level','sub'));
}

function updatesub(Request $r){
  $sub = implode(',',$r->sub);
  $data = [
    'id_sub'=>$sub
  ];
  $act = menu::where('id_side',$r->id)->update($data);
  if($act){
    return back()->with('message','success');
  }
}

public function add(Request $r){
  $data=[
    'name'=>$r->name,
    'url'=>$r->url,
    'is_active'=>$r->is_active,
    'icon'=>$r->icon,
    'dropdown'=>$r->dropdown,
    'active'=>$r->active,
    'sortby'=>$r->sortby,
    'type'=>$r->type
  ];
  $act = menu::insert($data);
  return back();
}

public function update(Request $r){
  $data=[
    'name'=>$r->name,
    'url'=>$r->url,
    'is_active'=>$r->is_active,
    'icon'=>$r->icon,
    'dropdown'=>$r->dropdown,
    'active'=>$r->active,
    'sortby'=>$r->sortby,
    'type'=>$r->type
  ];
  $act = menu::where($this->primary,$r->id)->update($data);
  return back();
}
public function hapus($id=null){
  $act = menu::where($this->primary,base64_decode($id))->delete();
  return back();
}

     }
