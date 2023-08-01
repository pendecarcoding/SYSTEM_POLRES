<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use App\Sp2hpModel;
use Session;
use App\Siswamodel;
use App\Gurumodel;
use App\Cmenu;
use App\PegawaiModel;
use App\UsulanModel;
class DashboardCo extends Controller
{
  public function __construct()
{
  $this->main  = "theme.dashboard";
  $this->index = $this->main.".dashboard";


}
 public function index(){
  if(Session::get('level')=='user'){
    $pegawai = PegawaiModel::where('kode_unitkerja',Session::get('kode_unitkerja'))->count();
    $D = UsulanModel::where('kode_unitkerja',Session::get('kode_unitkerja'))->where('jenis_cuti','D')->count();
    $S = UsulanModel::where('kode_unitkerja',Session::get('kode_unitkerja'))->where('jenis_cuti','S')->count();
    $L = UsulanModel::where('kode_unitkerja',Session::get('kode_unitkerja'))->where('jenis_cuti','L')->count();
    return view($this->index,compact('pegawai','S','D','L'));
  }else{
    $pegawai = PegawaiModel::count();
    $D = UsulanModel::where('jenis_cuti','D')->count();
    $S = UsulanModel::where('jenis_cuti','S')->count();
    $L = UsulanModel::where('jenis_cuti','L')->count();
    return view($this->index,compact('pegawai','S','D','L'));
  }
   
 }

 public function testlogika(){
   return view('theme.testlogika.index');
 }



     }
