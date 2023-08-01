<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InstansiModel;
use DataTables;
use Session;
use App\menu;
use App\PeminjamanModel;
use App\Level;
use App\Gurumodel;
use App\aksesmenuModel;
class JadwalCo extends Controller
{
  public function __construct()
{
  $this->primary = "id_peminjaman";
  $this->main    = "theme.jadwal";
  $this->level   = Session::get('level');
  $this->userid  = Session::get('id_user');
  $this->msukses = 'Data Berhasil disimpan';
  $this->msupdate = 'Data Berhasil diupdate';
  $this->index   = $this->main.".index";
  $this->lihat   = $this->main.".lihat";
  function createInv(){
          return [
              'code' => [
                  'format' => function () {
                      return date('Y.m.d') . '/INV/?';
                  },
                  'length' => 5
              ]
          ];
  }
}



public function index(){
  $data = Gurumodel::all();
  return view($this->index,compact('data'));
}
public function save(Request $r){
  $data=[
    'kebutuhan'=>$r->perihal,
    'lama'=>$r->lama,
    'tgl_permintaan'=>$r->tgl,
    'id_user'=>$r->iduser,
    'tagihan'=>$r->tagihan,
    'jam'=>$r->waktu,
    'dibayar'=>$r->dibayar,
    'status'=>$r->jenis,
    'konfirmasi'=>$r->konfirmasi
  ];
  $act = PeminjamanModel::insert($data);
  return back()->with('success',$this->msukses);
}
public function update(Request $r){
  $data=[
    'kebutuhan'=>$r->perihal,
    'lama'=>$r->lama,
    'tgl_permintaan'=>$r->tgl,
    'id_user'=>$r->iduser,
    'tagihan'=>$r->tagihan,
    'jam'=>$r->waktu,
    'dibayar'=>$r->dibayar,
    'status'=>$r->jenis,
    'konfirmasi'=>$r->konfirmasi
  ];
  $act = PeminjamanModel::where('id_peminjaman',$r->id)->update($data);
  return back()->with('success',$this->msupdate);
}

public function hapus($id=null){
  $check = PeminjamanModel::where('id_peminjaman',base64_decode($id))->count();
  if($check > 0){
    $act = PeminjamanModel::where($this->primary,base64_decode($id))->delete();
    return back()->with('success','Data berhasil dihapus');
  }else{
    return back()->with('danger','Data tidak tersedia');
  }

}
public function lihat($id=null){
  $check = PeminjamanModel::where('id_peminjaman',base64_decode($id))->count();
  if($check > 0){
    $data = PeminjamanModel::join('tbl_user','tbl_user.id_user','tbl_peminjaman.id_user')->where($this->primary,base64_decode($id))->first();
    return view($this->lihat,compact('data'));
  }else{
    return back()->with('danger','Data tidak tersedia');
  }

}


     }
