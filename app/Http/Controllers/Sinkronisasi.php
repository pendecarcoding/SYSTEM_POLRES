<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class Sinkronisasi extends Controller
      {
        public function __construct()
      {

      }

      public function main(Request $req){
          if($req->act){
            $data = file_get_contents(url('API/RASENGAN/datapegawai?kode_unitkerja='.session()->get('kode_unitkerja')));
            $file = public_path('api_static/'.session()->get('kode_unitkerja').'.json');
            $myfile = fopen($file, "w") or die("Unable to open file!");
            fwrite($myfile, $data);
            fclose($myfile);
            return redirect('sinkronisasi_data')->with('success','Berhasil Sinkronisasi Data');
          }
          return view('theme.sinkronisasi.main');
      }
      // public function save(Request $r){
      //   $data =[
      //
      //   ];
      //
      //   $act = Jabatan::insert($data);
      //   if($act){
      //     return back()->with();
      //   }
      //
      // }
      // public function update(Request $r){
      //   $data =[
      //
      //   ];
      //
      //   $act = Jabatan::where($r->id)->update($data);
      //   if($act){
      //     return back()->with(,);
      //   }
      //
      // }
      // public function hapus($id){
      //   $act = Jabatan::where(,base64_decode($id))->delete();
      //   if($act){
      //     return back()->with(,);
      //   }
      //
      // }
    }
