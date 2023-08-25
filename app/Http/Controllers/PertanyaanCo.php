<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use App\PertanyaanModel;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class PertanyaanCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
        $data = PertanyaanModel::orderby('short','asc')->get();
        return view('theme.pertanyaan.index',compact('data'));
      }
      public function save(Request $r){
        $data =[
          'short'=>$r->short,
          'pertanyaan'=>$r->pertanyaan,
        ];

        $act = PertanyaanModel::insert($data);
        if($act){
          return back()->with('success','Data berhasil disimpan');
        }

      }
      public function update(Request $r){
        $data =[
          'short'=>$r->short,
          'pertanyaan'=>$r->pertanyaan,
        ];

        $act = PertanyaanModel::where('id_pertanyaan',$r->id)->update($data);
        if($act){
          return back()->with('success','Data berhasil di update');
        }

      }
      public function hapus($id){
        $act = PertanyaanModel::where('id_pertanyaan',base64_decode($id))->delete();
        if($act){
          return back()->with('success','Data berhasil di hapus');
        }

      }
    }