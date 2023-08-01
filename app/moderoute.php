<?php
namespace App;
use App\RouteModel;
use Session;
ini_set('memory_limit', '-1');
class moderoute
{
  function get(){
    $data = RouteModel::where('active','Y')
             ->get();
    return($data);
  }

}
