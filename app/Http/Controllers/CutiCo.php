<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use DataTables;
      use Session;
      use App\TblCuti;
      use App\Cmenu;
      use Intervention\Image\ImageManagerStatic as Image;
      class CutiCo extends Controller
      {
        public function __construct()
      {

      }

      public function pengajuan(Request $r){
        $class       = new Cmenu();
        $listintansi = (object) $class->listinstansi();
        $skpd        = $listintansi;
        $datacuti    = TblCuti::all();
          return view('theme.cuti.index',compact('skpd','datacuti'));
      }
      public function save(Request $r){
        $data =[

        ];

        // $act = Jabatan::insert($data);
        // if($act){
        //   return back()->with();
        // }

      }
      public function update(Request $r){
        $data =[

        ];

        // $act = Jabatan::where(,$r->id)->update($data);
        // if($act){
        //   return back()->with(,);
        // }

      }
      public function hapus($id){
        // $act = Jabatan::where(,base64_decode($id))->delete();
        // if($act){
        //   return back()->with(,);
        // }

      }
    }