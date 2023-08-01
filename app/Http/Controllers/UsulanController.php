<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\Cmenu;
use App\PegawaiModel;
use App\UsulanModel;
class UsulanController extends Controller
{
  public function __construct()
{
  $this->main  = "theme.usulan";


}
 public function usulandinas(){
  if(Session::get('level')=='user'){
    $data = UsulanModel::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
    return view($this->main.'.dinas',compact('data'));
  }else{
    $data = UsulanModel::where('kode_unitkerja')->get();
    return view($this->main.'.dinas',compact('data'));
  }
   
 }

 public function usulansakit(){
    if(Session::get('level')=='user'){
      $data = UsulanModel::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
      return view($this->main.'.sakit',compact('data'));
    }else{
      $data = UsulanModel::where('kode_unitkerja')->get();
      return view($this->main.'.sakit',compact('data'));
    }
     
   }



 


     }
