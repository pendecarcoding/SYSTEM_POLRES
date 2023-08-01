<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\RouteModel;
use Helper;
class RouteCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_route";
  $this->main    = "theme.route";
  $this->index   = $this->main.".index";

}

 public function index(){
   $data = RouteModel::all();
   return view($this->index,compact('data'));
 }

 public function add(Request $r){
   $controller = $r->controller.'.php';
   $akses  = implode(',',$r->akses);
   $data=[
     'type'=>$r->type,
     'link'=>$r->link,
     'controller'=>$r->controller,
     'active'=>$r->active,
     'session'=>$akses,
     'method'=>$r->method
   ];
   $dir = app()->basePath()."/app/Http/Controllers";
   if(file_exists($dir."/".$controller)){
     $act = RouteModel::insert($data);
     if($act){
       return back()->with('success','Data Berhasil disimpan');
     }
   }else{
     $content = Helper::createController($r->controller,$r->method);
     $file    = fopen($dir."/".$controller,"w");
     fwrite($file, $content);
     fclose($file);
     $act = RouteModel::insert($data);
     if($act){
       return back()->with('success','Data Berhasil disimpan');
     }
   }
 }

 public function update(Request $r){
   $akses  = implode(',',$r->akses);
   $data=[
     'type'=>$r->type,
     'link'=>$r->link,
     'controller'=>$r->controller,
     'active'=>$r->active,
     'session'=>$akses,
     'method'=>$r->method
   ];
   $act = RouteModel::where($this->primary,$r->id)->update($data);
   return back();
 }
 public function hapus($id=null){
   $act = RouteModel::where($this->primary,base64_decode($id))->delete();
   return back();
 }



     }
