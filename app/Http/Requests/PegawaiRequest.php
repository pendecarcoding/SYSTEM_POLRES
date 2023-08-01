<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nip'=>'required|unique:tbl_pegawai',
            'nama'=>'required',
            'email'=>'required',
            'gd'=>'required',
            'gb'=>'required',
            'nohp'=>'required',
            'image'=>'required',
            'status'=>'required',
        ];
    }
}
