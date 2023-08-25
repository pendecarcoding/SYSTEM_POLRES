<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use App\PelayananModel;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class PelayananCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
          $data = PelayananModel::all();
          return view('theme.pelayanan.index',compact('data'));
      }
      public function save(Request $r){
        $data =[
          'pelayanan'=>$r->pelayanan
        ];
        $act = PelayananModel::insert($data);
        if($act){
          return back()->with('success','Data berhasil disimpan');
        }

      }
      public function update(Request $r){
        $data =[
          'pelayanan'=>$r->pelayanan
        ];

        $act = PelayananModel::where('id_pelayanan',$r->id)->update($data);
        if($act){
          return back()->with('success','Data Berhasil diupdate');
        }

      }
      public function hapus($id){
        $act = PelayananModel::where('id_pelayanan',base64_decode($id))->delete();
        if($act){
          return back()->with('success','Data berhasil dihapus');
        }

      }
      public function grafikikm(){
        return view('theme.pelayanan.grafik');
      }
    }