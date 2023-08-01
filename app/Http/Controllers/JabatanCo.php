<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use App\Jabatan;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class JabatanCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
        $data = Jabatan::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
          return view('theme.jabatan.index',compact('data'));
      }

      public function save(Request $r){
        $data =[
          'jabatan'=>$r->jabatan,
          'kode_unitkerja'=>Session::get('kode_unitkerja'),
        ];

        $act = Jabatan::insert($data);
        if($act){
          return back()->with('success','Data Berhasil disimpan');
        }

      }
      public function update(Request $r){
        $data =[
          'jabatan'=>$r->jabatan,
          'kode_unitkerja'=>Session::get('kode_unitkerja'),
        ];

        $act = Jabatan::where('id_jabatan',$r->id)->update($data);
        if($act){
          return back()->with('success','Data Berhasil diupdate');
        }else{
          return back()->with('success','Data tidak ada yang diupdate');

        }

      }
      public function hapus($id){
        $act = Jabatan::where('id_jabatan',base64_decode($id))->delete();
        if($act){
          return back()->with('success','Data Berhasil di hapus');
        }

      }
    }
