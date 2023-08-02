<?php

use App\RouteModel;
use App\Loginmodel;
use App\Cmenu;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::match(['get','post'],'/API/{key}/{url}','AndroCo@apiandro');
//login
Route::match(['get','post'],'/','FrontendCo@index');
Route::match(['get','post'],'/login','LoginCo@index');

Route::match(['get','post'],'/chat','AndroCo@chat');
Route::get('mulaipesan','FrontendCo@mulai');
Route::get('/login','LoginCo@index');
Route::match(['get','post'],'loginpost','LoginCo@post');

//
Route::get('twakto/message','FrontendCo@twakto');
Route::get('home','FrontendCo@index');
Route::get('jadwal','FrontendCo@jadwal');
Route::get('gridmenu','AndroCo@gridmenu');
Route::match(['get','post'],'gridmenuname','AndroCo@gridmenuname');
Route::match(['get','post'],'gridmenulogic','AndroCo@gridmenulogic');
Route::match(['get','post'],'ubahpassword','AndroCo@ubahpassword');
Route::match(['get','post'],'infoakun', 'AndroCo@infoakun');
Route::match(['get','post'],'getproduk', 'AndroCo@getproduk');

Route::match(['get','post'],'loginmasyarakat', 'AndroCo@loginmasyarakat');
Route::match(['get','post'],'addakunmasyarakat', 'AndroCo@addmasyarakat');
Route::match(['get','post'],'pesanproduk', 'AndroCo@pesanproduk');
Route::match(['get','post'],'daftarpemilikusaha','CatringCo@daftarpemilikusaha');
//listpemesananbyname
Route::match(['get','post'],'listpemesananbyname', 'AndroCo@listpemesananbyname');
Route::match(['get','post'],'listpemesanan', 'AndroCo@listpemesanan');
Route::post('daftarmasyarakat', function() {
  $message = array();
  $photo = Request::input('foto');
  $photo = str_replace('data:image/png;base64,', '', $photo);
  $photo = str_replace(' ', '+', $photo);
  $img   = base64_decode($photo);
  $file  = uniqid() . '.png';
  //$kodedaftar = date('Y').rand(15,35).date('m').date('s');
  $email =Request::input('email');
  $check = Loginmodel::where('email',Request::input('email'))->count();
  if($check > 0){
    $message=[
      'msg'=>'Email sudah digunakan',
      'id'=>null
    ];
  }else{
    $data =[
      'nama'=>Request::input('nama'),
      'alamat'=>Request::input('alamat'),
      'nohp'=>Request::input('nohp'),
      'email'=>Request::input('email'),
      'username'=>Request::input('email'),
      'foto'=>$file,
      'level'=>'masyarakat',
      'jk'=>Request::input('jk'),
      'blokir'=>'N',
      //'kodedaftar'=>$kodedaftar,
      'password'=>md5(Request::input('password'))
    ];
    $act = Loginmodel::insertGetId($data);
    if(!$act){
      $message=[
        'msg'=>'INVALID',
        'id'=>null
      ];
    }else{
      file_put_contents(public_path().'/theme/users/'.$file, $img);
      //file_put_contents(public_path().'/theme/users/ktp/'.$filektp, $imgktp);
      //Mail::to($email)->send(new App\Mail\Pendaftaran($kodedaftar));
      $message=[
        'msg'=>'VALID',
        'id'=>$act
      ];
    }

  }
    print json_encode($message);
});
Route::group(['middleware'=>['usersession']],
function(){
  $class     = new Cmenu();
  $routes = json_decode($class->listroute());
   if(!empty($routes)){
     
      foreach ($routes as $key => $route) {
        Route::match(['get','post'],$route->link,$route->controller.'@'.$route->method);
      }
   
     
   
 }else{
   return redirect('login');
 }



//fetch Route hahahaha (Its Work :-))

}
);
