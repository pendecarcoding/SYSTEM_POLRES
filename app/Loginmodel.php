<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Loginmodel extends Model
{
  protected $table = 'tbl_user';
  public $timestamps = false;
  protected $fillable = [
        'id_user',
        'nama',
        'username',
        'password',
        'level',
        'foto',
        'email',
        'nohp',
        'jk',
        'alamat',
        'blokir',
        'kode_unitkerja',
        'id_bidang',
    ];
}
