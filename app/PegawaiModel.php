<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class PegawaiModel extends Model
{
  protected $table = 'tbl_pegawai';
  public $timestamps = true;
  protected $fillable = [
    'nip',
    'nama',
    'email',
    'pangkat_gol',
    'gd',
    'gb',
    'nohp',
    'image',
    'status',
    'kode_unitkerja'
];
  

}
