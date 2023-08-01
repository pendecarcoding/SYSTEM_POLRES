<?php

namespace App\Http\Repository;
use App\PegawaiModel;
use App\Http\Interfaces\PegawaiInterfaces;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Helper; 
use Session;
use File;
class PegawaiRepository implements PegawaiInterfaces
{
    protected $model;

    public function __construct(PegawaiModel $post)
    {
        $this->model = $post;
    }

    public function all()
    {
        return $this->model->where('kode_unitkerja',Session::get('kode_unitkerja'))->orderby('id','DESC')->paginate(10);
    }

      public function base64_decode($image,$titleimg){
        $photo = str_replace('data:image/png;base64,', '', $image);
        $photo = str_replace(' ', '+', $photo);
        $img   = base64_decode($photo);
        File::makeDirectory(public_path().'/pegawai/'.Session::get('kode_unitkerja'), $mode = 0777, true, true);
        file_put_contents(public_path().'/pegawai/'.Session::get('kode_unitkerja').'/'.$titleimg, $img);
        
                
    }
    
    public function create(array $data, String $image,String $titleimg)
    {  
       if($this->model->create($data)){
           return $this->base64_decode($image,$titleimg);
        }    
    }
    public function update(array $data, $id)
    {

        try {
            $this->model->where('id', $id)
            ->update($data);
            return back()->with('success','Update Successfull!');
        } catch (Throwable $e) {
            report($e);
            return false;
        }
        
    }

    public function updateimage(array $data, $id,String $image,String $titleimg,String $imageold)
    {

        try {
            $this->model->where('id', $id)
            ->update($data);
            if(file_exists(public_path('pegawai/'.Session::get('kode_unitkerja').'/'.$imageold))){
            unlink(public_path('pegawai/'.Session::get('kode_unitkerja').'/'.$imageold));
                return $this->base64_decode($image,$titleimg);
            }else{
                return $this->base64_decode($image,$titleimg);
               
            }
             return back()->with('success','Update Successfull!');
            
        } catch (Throwable $e) {
            report($e);
            return false;
        }
        
    }

    public function delete($id)
    {
        if($this->model->find($id) != null){
            $namafile = $this->model->find($id)->image;
            if($this->model->destroy($id)){
            if(file_exists(public_path('pegawai/'.Session::get('kode_unitkerja').'/'.$namafile))){
            unlink(public_path('pegawai/'.Session::get('kode_unitkerja').'/'.$namafile));
            return back()->with('success','Delete Successfull');
            }
           }else{
            return back()->with('danger','Eror Delete');
           }
            
        }
        
    }

 
    
    public function find($id)
    {
            $post = $this->model->find($id);
            return $post;        
        
    }
}