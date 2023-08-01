<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
class InstansiCo extends Controller
{
  public function __construct()
  {
  $this->middleware(function ($request, $next) {
  $uInfo = Session::get('login');
  $level = Session::get('level');
  if(!isset($uInfo) && empty($uInfo))
  {
    return redirect('/login')->with('danger','Anda harus login dulu');
  }
  else {
    if($level != 'teknis')
    {
      return redirect('main');
    }
  }
  return $next($request);
  });

}



 public function index(){
   return view("skp_user.teknis.instansi.instansi");
 }

 public function listinstansi(){
   $data = InstansiModel::all();
   $result= array();
   foreach ($data as $key => $value) {

     array_push($result,array(
       "no"=>$key+1,
       "kode_unitkerja"=>$value->kode_unitkerja,
       "nama_unitkerja"=>$value->nama_unitkerja,
       "kecamatan"=>$value->kecamatan,
       "alamat"=>$value->alamat
             )
           );
         }

         return Datatables::of($result)->make(true);

       }


     }
