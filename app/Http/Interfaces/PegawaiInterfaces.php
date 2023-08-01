<?php

namespace App\Http\Interfaces;

interface PegawaiInterfaces
{
    public function all();
    public function create(array $data, String $image,String $titleimg);
    public function update(array $data, $id);
    public function updateimage(array $data, $id,String $image,String $titleimg,String $imageold);
    public function delete($id);
    public function find($id);
}