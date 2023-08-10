<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use App\TblDinas;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class DinasCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
        if(Session::get('level')=='user'){
          $data = TblDinas::where('id_instansi',Session::get('kode_unitkerja'))->get();
          return view('theme.usulan.dinas',compact('data'));
        }
          
      }
      public function save(Request $r){
        $data =[

        ];

        $act = "";
        if($act){
          return back()->with();
        }

      }
      public function update(Request $r){
        $data =[

        ];

        $act = "";
        // if($act){
        //   return back()->with("",);
        // }

      }
      public function hapus($id){
        // $act = Jabatan::where(,base64_decode($id))->delete();
        // if($act){
        //   return back()->with(,);
        // }

      }
    }