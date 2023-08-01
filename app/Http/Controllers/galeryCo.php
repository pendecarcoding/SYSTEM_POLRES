<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\Level;
use App\galerymodel;
use App\aksesmenuModel;
use Intervention\Image\ImageManagerStatic as Image;
class galeryCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_galery";
  $this->main    = "theme.galery";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = galerymodel::all();
  return view($this->index,compact('data'));
}
public function save(Request $r){
  if($r->file('file')) {
    $r->validate([
       'file' => 'required|mimes:png,jpg,jpeg|max:2048'
    ]);
        $file = $r->file('file');
        $ext  = $file->getClientOriginalExtension();
        $name = time().'.'.$ext;
        $image_resize = Image::make($file->getRealPath());
        $image_resize->resize(800, 600);
        $image_resize->save(public_path('theme/galery/'.$name));
        $data=[
          'judul'=>$r->judul,
          'file'=>$name
        ];
        $act = galerymodel::insert($data);
        return back()->with('success',$this->msukses);
   }

}
public function update(Request $r){
  if($r->file('file')) {
    $r->validate([
       'file' => 'required|mimes:png,jpg,jpeg|max:2048'
    ]);
        $file = $r->file('file');
        $ext  = $file->getClientOriginalExtension();
        $name = time().'.'.$ext;
        $image_resize = Image::make($file->getRealPath());
        $image_resize->resize(800, 600);
        $image_resize->save(public_path('theme/galery/'.$name));
        if($r->logold != 'admin.png'){
        if(file_exists(public_path('theme/galery/'.$r->logold)))
        {
        unlink(public_path('theme/galery/'.$r->logold));
        }
        }
        $data=[
          'judul'=>$r->judul,
          'file'=>$name
        ];
        $act = galerymodel::where('id_galery',$r->id)->update($data);
        return back()->with('success',$this->msukses);
   }else{
     $data=[
       'judul'=>$r->judul
     ];
     $act = galerymodel::where('id_galery',$r->id)->update($data);
     return back()->with('success',$this->msukses);
   }
}

public function hapus($id=null){
  $check = galerymodel::where('id_galery',base64_decode($id))->count();
  if($check > 0){
    $act = galerymodel::where($this->primary,base64_decode($id))->delete();
    return back()->with('success','Data berhasil dihapus');
  }else{
    return back()->with('danger','Data tidak tersedia');
  }

}


     }
