<?php
namespace App;
/**
 *
 */
class Fungsi
{
  static function all_pegawai(){
    return json_decode(fgets(fopen(public_path("api_static/".session()->get('kode_unitkerja').".json"),"r")),true);
  }
  static function get_pegawai_no($no){

    return json_decode(json_encode(collect(self::all_pegawai())->where('no',$no)->first()));
  }
}
