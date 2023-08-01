<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sekolah;
use App\Desa;
use App\Kecamatan;
use App\Zona;
class SekolahController extends Controller
{
  public function index()
    {
		//join tabel untuk menampilkan data kecamatan pada combobox
        $sekolah = Sekolah::join('tbl_zona', 'tbl_zona.id_zona','tbl_zona.id_sekolah')
		->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan','tbl_zona.id_kecamatan')
		->join('tbl_desa', 'tbl_desa.id_desa','tbl_zona.id_desa')
		->get();
		$kecamatan = Kecamatan::all();
		$desa = Desa::all();
		$zona = Zona::all();
        return view('backend.sekolah.dataSekolah',['desa'=>$desa],['kec'=>$kecamatan], ['sekolah'=>$sekolah], ['zona'=>$zona]);
    }
    /**
     * Show the application dataDesa
     *
     * @return \Illuminate\Http\Response
     */
	 public function tambah(Request $r){
        $data=[
            'nm_sekolah'=>$r->sekolah,
			'id_desa'=>$r->desa,
			'id_kecamatan'=>$r->kecamatan,
			'id_zona'=>$r->zona
            ];
        $action = Desa::insert($data);
        return back();
    }
     public function edit($id=null){
        $edit=Desa::where('id_desa',$id)->first();
		$desa= Desa::all();
        $kecamatan = Kecamatan::all();
        return view('backend.sekoalah.dataSekolah',['desa' => $desa],['kec'=>$kecamatan],['edit'=>$edit]);
    }
 
   public function update(Request $r){
        $data=[
			'id_sekolah'=>$r->sekolah,
            'id_desa'=>$r->desa,
			'id_kecamatan'=>$r->kecamatan,
			'id_desa'=>$r->zona
            ];
        $action = Sekolah::where('id_sekolah',$r->id)->update($data);
        return back()->with('success','Data Berhasil di update');
    }
    public function delete($id=null){
        $action = Sekolah::where('id_sekolah',$id)->delete();
        return redirect('/dataSekolah')->with('success','Data Berhasil di hapus');
    }
}


