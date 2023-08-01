<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\RouteModel;
use App\Loginmodel;
use App\JamModel;
use Intervention\Image\ImageManagerStatic as Image;
session_start();
class Helper {
    public static function cekhari(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini;
 

    }
    public static function getusers($username){
      try {
        $data = Loginmodel::where('username',$username)->first();
        return $data;
      } catch (\Throwable $th) {
        return $th->getmessage();
      }
    }
    public static function createController($controller,$method){
      $file = '<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class '.$controller.' extends Controller
      {
        public function __construct()
      {

      }

      public function '.$method.'(){
          print("success");
      }
      public function save(Request $r){
        $data =[

        ];

        $act = Jabatan::insert($data);
        if($act){
          return back()->with();
        }

      }
      public function update(Request $r){
        $data =[

        ];

        $act = Jabatan::where(,$r->id)->update($data);
        if($act){
          return back()->with(,);
        }

      }
      public function hapus($id){
        $act = Jabatan::where(,base64_decode($id))->delete();
        if($act){
          return back()->with(,);
        }

      }
    }';
      return $file;

}
    public static function get_route() {

      $result = array();
      $level  = session()->get('level');
      $data = RouteModel::where('active','Y')
               ->get();
               foreach ($data as $key => $route) {
                 $mn = explode(',',$route->session);

                 //$mn = array("admin", "Joe", "Glenn", "Cleveland");

                   if(!empty($_SESSION["level"]) AND in_array($_SESSION["level"],$mn)){
                     $dt=[
                       'link'=>$route->link,
                       'controller'=>$route->controller,
                       'method'=>$route->method
                     ];
                      array_push($result,$dt);
                   }



               }
              return json_encode($result);
    }

    public static function test (){
      print "berhasil";
    }

    public function ImageSave($file,$path){
        $ext  = $file->getClientOriginalExtension();
        $name = time().'.'.$ext;
        $image_resize = Image::make($file->getRealPath());
        $image_resize->resize(300, 300);
        $image_resize->save(public_path($path.'/'.$name));
          if(file_exists(public_path($path.'/'.$ref)))
           {
              unlink(public_path($path.'/'.$ref));
           }
       
    }

    public static function jam($hari,$jenis,$unitkerja){

      $data = JamModel::where('kode_unitkerja',$unitkerja)
              ->where('jenis',$jenis)
              ->where('hari',$hari)
              ->first();
      if($data != null){
        return $data;
      }else{
        $data =[
          'jam'=>"<a class='btn btn-danger'>Belum Diatur</a>",
          'batas'=>"<a class='btn btn-danger'>Belum Diatur</a>",
        ];
        return $data;
      }


    }
}
