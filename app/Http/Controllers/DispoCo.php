<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use App\DispoJenis;
      use App\Aktor;
      use App\Alur;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class DispoCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
          $data = DispoJenis::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
          return view('theme.disposisi.jenisdisposisi',compact('data'));
      }
      public function save(Request $r){
        $data = [
          'jenis'=>$r->jenis,
          'kode_unitkerja'=>Session::get('kode_unitkerja'),
        ];
        $act = DispoJenis::insert($data);
        if($act){return back()->with('success','Data Berhasil disimpan');}
      }




      public function hapusaktor($id){
        $act = Aktor::where('id_alur',base64_decode($id))->count();
        if($act > 0){
          $act = Aktor::where('id_alur',base64_decode($id))->delete();
          if($act){
            return back()->with('success','Data berhasil dihapus');
          }
        }
      }

      public function tambahalur(Request $r){
        $data=[
          'id_disposisi'=>$r->id_disposisi,
          'tahap'=>$r->tahap,
          'jabatan'=>$r->jabatan,
          'aksi'=>$r->aksi,
          'kode_unitkerja'=>Session::get('kode_unitkerja'),
        ];
        $act = Alur::insert($data);
        if($act){
          return back()->with('success','Data berhasil disimpan');
        }
      }
      public function updatealur(Request $r){
        $data=[
          'id_disposisi'=>$r->id_disposisi,
          'tahap'=>$r->tahap,
          'jabatan'=>$r->jabatan,
          'aksi'=>$r->aksi,
          'kode_unitkerja'=>Session::get('kode_unitkerja'),
        ];
        $act = Alur::Where('id_alur',$r->id)->update($data);
        if($act){
          return back()->with('success','Data berhasil diupdate');
        }
      }
    }
