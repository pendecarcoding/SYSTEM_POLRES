<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use DataTables;
      use Session;
      use DB;
      use Intervention\Image\ImageManagerStatic as Image;
      class SuratMasukCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
        $index = DB::table('data_surat')->join('jenis_surat','jenis_surat.id','data_surat.id_surat')->where('data_surat.kode_unitkerja',Session::get('kode_unitkerja'))->get();

        return view('theme.e-surat.keluar.list',compact('index'));
      }

      function create(Request $req){
        
      }
    }
