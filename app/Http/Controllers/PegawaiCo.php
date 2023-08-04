<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\PegawaiRequest;
use App\Http\Interfaces\PegawaiInterfaces;
use Session;
class PegawaiCo extends Controller
{

  private $pg;
  public function __construct(PegawaiInterfaces $pg)
{
  $this->primary = "id_pegawai";
  $this->main    = "theme.pegawai";
  $this->index   = $this->main.".index";
  $this->DI      = $pg;

}

 public function index(){
   $data = $this->DI->all();
   return view($this->index,compact('data'));
 }

 public function create(Request $r){
  try {
    if($r->has('file')){
    $imgbase64 = base64_encode(file_get_contents($r->file('file')));
    $titleimg  = uniqid().'.png';
    $data = [
      'nip'=>$r->nip,
      'nama'=>$r->nama,
      'email'=>$r->email,
      'gd'=>$r->gd,
      'gb'=>$r->gb,
      'nohp'=>$r->nohp,
      'pangkat_gol'=>$r->pangkat_gol,
      'image'=>$titleimg,
      'satatus'=>'ASN',
      'kode_unitkerja'=>Session::get('kode_unitkerja'),
      'cerated_at'=>now(),
      'updated_at'=>now()
    ];
    $this->DI->create($data,$imgbase64,$titleimg);
    return back()->with('success','Data berhasil disimpan');
    }
  } catch (\Throwable $th) {
    return back()->with('danger',$th->getmessage());
  }
   
 }

 public function update(Request $r){
   try {
    if($r->has('file')){
    $imgbase64 = base64_encode(file_get_contents($r->file('file')));
    $titleimg  = uniqid().'.png';
    $imageold  = $r->imageold;
    $id        = $r->id;
    $data = [
      'nip'=>$r->nip,
      'nama'=>$r->nama,
      'email'=>$r->email,
      'gd'=>$r->gd,
      'gb'=>$r->gb,
      'nohp'=>$r->nohp,
      'pangkat_gol'=>$r->pangkat_gol,
      'image'=>$titleimg,
      'status'=>'ASN',
      'kode_unitkerja'=>Session::get('kode_unitkerja'),
      'created_at'=>now(),
      'updated_at'=>now()
    ];
    $this->DI->updateimage($data,$id,$imgbase64,$titleimg,$imageold);
    return back()->with('success','Data berhasil disimpan');
    }else{
      $id   = $r->id;
      $data = [
        'nip'=>$r->nip,
        'nama'=>$r->nama,
        'email'=>$r->email,
        'gd'=>$r->gd,
        'gb'=>$r->gb,
        'nohp'=>$r->nohp,
      ];
      return $this->DI->update($data,$id);
      
    }
  } catch (\Throwable $th) {
    return back()->with('danger',$th->getmessage());
  }

   
 }
 public function delete($id=null){
   try {
    return $this->DI->delete(base64_decode($id));
   } catch (\Throwable $th) {
    return back()->with('danger',$th->getmessage());
   }
 }



     }
