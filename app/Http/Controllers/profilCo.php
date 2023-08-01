<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\level;
use App\UserModel;
use Intervention\Image\ImageManagerStatic as Image;
class profilCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_user";
  $this->main    = "theme.profil";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->index   = $this->main.".index";

}

public function index(){
  $data  = UserModel::where('level',Session::get('level'))
           ->where('id_user',Session::get('id_user'))
           ->first();
        //  print $this->level;
  return view($this->index,['data'=>$data]);
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
        $image_resize->resize(300, 300);
        $image_resize->save(public_path('theme/users/'.$name));
        if($r->logold != 'admin.png'){
        if(file_exists(public_path('theme/users/'.$r->logold)))
        {
        unlink(public_path('theme/users/'.$r->logold));
        }
        }
        $data=[
          'nama'=>$r->nama,
          'username'=>$r->username,
          'alamat'=>$r->alamat,
          'email'=>$r->email,
          'nohp'=>$r->nohp,
          'foto'=>$name
        ];
        $act = UserModel::where($this->primary,$r->id)->update($data);
        return back()->with('success','Data Berhasil diupdate');
   }
   else{
     $data=[
       'nama'=>$r->nama,
       'username'=>$r->username,
       'alamat'=>$r->alamat,
       'email'=>$r->email,
       'nohp'=>$r->nohp
     ];
     $act = UserModel::where($this->primary,$r->id)->update($data);
     return back()->with('success','Data Berhasil diupdate');
   }

}

public function updatepass(Request $r){
  $check = UserModel::where($this->primary,$r->id)->count();
  if($check > 0){
    $profil = UserModel::where($this->primary,$r->id)->first();
    $passlamap = $profil->password;
    $passlama  = md5($r->passlama);
    if($passlama <> $passlamap ){
      return back()->with('danger','Password Lama Salah, Coba Lagi !!!');
    }else{
      $data=[
        'password'=>md5($r->passbaru)
      ];
      $act = UserModel::where($this->primary,$r->id)->update($data);
      return back()->with('success','Data Berhasil Disimpan');
    }

  }else{
    return back()->with('danger','Data tidak tersedia !!!');;
  }


}

public function hapus($id=null){
  $act = menu::where($this->primary,base64_decode($id))->delete();
  return back();
}

     }
