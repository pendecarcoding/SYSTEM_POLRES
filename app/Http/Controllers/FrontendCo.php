<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Loginmodel;
use DataTables;
use Session;
use App\UserModel;
use Intervention\Image\ImageManagerStatic as Image;
class FrontendCo extends Controller
{
  public function __construct()
{
  $this->main       = "frontend";
  $this->index      = $this->main.".index";
  $this->mulaipesan = $this->main.".mulaipesan";
  $this->jadwal     = $this->main.".jadwal";


}

public function twakto(){
  return view('twakto.index');
}

 public function daftaruser(Request $r){
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
         $data=[
           'nama'=>$r->nama,
           'alamat'=>$r->alamat,
           'nohp'=>$r->nohp,
           'email'=>$r->email,
           'level'=>'masyarakat',
           'blokir'=>'N',
           'password'=>md5($r->password),
           'username'=>$r->username,
           'foto'=>$name
         ];
         $act = UserModel::insert($data);
         return back()->with('success','Pendaftaran Berhasil');
    }
 }

 public function index(){
   return view($this->index);
 }
 public function mulai(){
   return view($this->mulaipesan);
 }
 public function jadwal(){
   return view($this->jadwal);
 }



 public function logout(){
   Session::flush();
   return redirect('/login');
 }
 public function post(Request $r){
   $check = Loginmodel::where('username',$r->uname)
               ->where('password',md5($r->pass))
               ->count();
   if($check > 0){
     $data = Loginmodel::where('username',$r->uname)
                 ->where('password',md5($r->pass))
                 ->first();
                 Session::put('level',$data->level);
                 Session::put('id_user',$data->id_user);
                 Session::put('login',TRUE);
     return redirect('dashboard');
   }else{
     return redirect('login')->with('danger','Akun Tidak Tersedia');
   }
 }



     }
