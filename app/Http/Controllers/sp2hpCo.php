<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\level;
use App\Loginmodel;
use App\Sp2hpModel;
use App\aksesmenuModel;
class sp2hpCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_sp2hp";
  $this->main    = "theme.sp2hp";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_sp2hp');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = Sp2hpModel::orderBy('nama','ASC')->get();
  return view($this->index,['data'=>$data]);
}
public function cari(){
  return view($this->main.'.search');
}
public function caridokumen(Request $r){
  $check = Sp2hpModel::where('nama',$r->nama)
           ->where('no_lap',$r->nolap)
           ->count();
  if($check > 0){
    $data = Sp2hpModel::where('nama',$r->nama)
             ->where('no_lap',$r->nolap)
             ->first();
    return view($this->main.'.dokumen',compact('data'));
  }else{
    return view($this->main.'.notfound');
  }

}
public function save(Request $r){
  $r->validate([
     'file' => 'required|mimes:pdf|max:2048'
  ]);

  $file = $r->file('file');
  $name = $file->getClientOriginalName();
  $file->move('upload/',$r->nama.'_'.$r->nolaporan.'.pdf');
  $data=[
    'nama'=>$r->nama,
    'no_lap'=>$r->nolaporan,
    'file'=>$r->nama.'_'.$r->nolaporan.'.pdf'
  ];
  $act = Sp2hpModel::insert($data);
  return back()->with('success',$this->msukses);
}
public function update(Request $r){
  if($r->file('file')) {
    $file = $r->file('file');
    $name = $file->getClientOriginalName();
    $file->move('upload/',$r->nama.'_'.$r->nolaporan.'.pdf');
    $data=[
      'nama'=>$r->nama,
      'no_lap'=>$r->nolaporan,
      'file'=>$r->nama.'_'.$r->nolaporan.'.pdf'
    ];
    $act = Sp2hpModel::where($this->primary,$r->id)->update($data);
  }else{
    $name = $r->nmfile;
    $data=[
      'nama'=>$r->nama,
      'no_lap'=>$r->nolaporan,
      'file'=>$name
    ];
    $act = Sp2hpModel::where($this->primary,$r->id)->update($data);
  }
  return back()->with('success',$this->msupdate);
}

public function hapus($id=null){
  $data = Sp2hpModel::where('id_sp2hp',base64_decode($id))->first();
  $nmfile = $data->file;
  if($nmfile <>''){
    if(file_exists( public_path().'upload/'.$nmfile)){
      $file_path = public_path().'upload/'.$nmfile;
      unlink($file_path);
    }

  }
  $act = Sp2hpModel::where($this->primary,base64_decode($id))->delete();
  return back()->with('success','Data Berhasil di hapus');
}




     }
