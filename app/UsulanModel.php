<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class UsulanModel extends Model
{
  //use HasApiTokens;
  protected $table = 'tbl_usulan';
  public $timestamps = false;
}
