<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Loginmodel;
use DataTables;
use Session;
class LoginCo extends Controller
{
  public function __construct()
{
  $this->main  = "theme.login";
  $this->index = $this->main.".login";
}

 public function index(){
   return view($this->index);
 }

 public function logout(){
   Session::flush();
   return redirect('/login');
 }
 public function listroute(){
   print Session::get('level');
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
                 $_SESSION["level"] = $data->level;
                 Session::put('id_user',$data->id_user);
                 Session::put('kode_unitkerja',$data->kode_unitkerja);
                 Session::put('login',TRUE);
     return redirect('dashboard');
   }else{
     return redirect('login')->with('danger','Akun Tidak Tersedia');
   }
 }



     }
