<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
class User
{
  public function __construct()
  {
    $this->cekLogin();
  }
  public function getId()
  {
    $id = Session::get('level');
    return $id;
  }
  public function getLevel()
  {

  }
  public function cekLogin(){
    //$uInfo = Session::get('login');
    $level = Session::get('level');
    if(empty($level))
    {
      header('location:'.url('login'));
    }
    else {
      if($level != 'operator')
      {
        return header('location:'.url('main'));
      }
    }
}
}
