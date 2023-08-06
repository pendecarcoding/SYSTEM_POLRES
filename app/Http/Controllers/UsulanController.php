<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\Cmenu;
use App\TblCuti;
use App\PegawaiModel;
use App\UsulanModel;
class UsulanController extends Controller
{
  public function __construct()
{
  $this->main  = "theme.usulan";


}
 public function usulancuti(){
    if(Session::get('level')=='user'){
      $data = TblCuti::where('id_instansi',Session::get('kode_unitkerja'))->get();
      return view($this->main.'.cuti',compact('data'));
    }else{
     
    }
     
   }



 


     }
