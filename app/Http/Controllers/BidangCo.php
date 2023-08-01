<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use App\Penempatans;
      use App\PegawaiModel;
      use App\Jabatan;
      use App\Bidang;
      use DataTables;
      use Session;
      use Intervention\Image\ImageManagerStatic as Image;
      class BidangCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
          $data = Bidang::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
          return view('theme.bidang.index',compact('data'));
      }
      public function save(Request $r){
        $data =[
         'bidang'=>$r->bidang,
         'kode_unitkerja'=>Session::get('kode_unitkerja'),
        ];
        $act = Bidang::insert($data);
        if($act){
          return back()->with('success','Data Berhasil disimpan');
        }

      }
      public function update(Request $r){
        $data =[
          'bidang'=>$r->bidang,
          'kode_unitkerja'=>Session::get('kode_unitkerja'),
        ];
        $act = Bidang::where('id_bidang',$r->id)->update($data);
        if($act){
         return back()->with('success','Data berhasil diupdate');
       }else{
         return back()->with('success','Tidak ada data berubah');

       }

      }
      public function hapus($id){
       $act = Bidang::where('id_bidang',base64_decode($id))->delete();
        if($act){
        return back()->with('success','Data berhasil dihapus');
        }

      }

      public function addpenempatan(Request $r){
        $data =[
          'no'=>$r->pegawai,
          'id_bidang'=>$r->id_bidang,
          'jabatan'=>$r->jabatan,
        ];
        $act = Penempatans::insert($data);
        if($act){
          return back()->with('success','Data berhasil disimpan');
        }
      }

      public function updatepenempatan(Request $r){
        $data =[
          'no'=>$r->pegawai,
          'id_bidang'=>$r->id_bidang,
          'jabatan'=>$r->jabatan,
        ];
        $act = Penempatans::where('id',$r->id)->update($data);
        if($act){
          return back()->with('success','Data berhasil diupdate');
        }
      }

      public function hapuspenempatan($id){
        $c = Penempatans::where('id',base64_decode($id))->count();
        if($c > 0){
          $act = Penempatans::where('id',base64_decode($id))->delete();
          if($act){
            return back()->with('success','Data berhasil dihapus');
          }
        }
      }



      public function penempatan(Request $r){
        $jabatan = Jabatan::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
        $pegawai = PegawaiModel::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
        $data = Bidang::where('kode_unitkerja',Session::get('kode_unitkerja'))->get();
        $penempatan = PegawaiModel::join('tbl_penempatan','tbl_penempatan.no','tbl_pegawai.id')
                      ->where('id_bidang',base64_decode($r->lihatpegawai))
                      ->get();
        return view('theme.bidang.penempatan',compact('data','pegawai','jabatan','penempatan'));
      }
    }
