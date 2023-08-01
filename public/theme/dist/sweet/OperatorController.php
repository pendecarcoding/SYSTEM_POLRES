<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.operator.dataOperator');
    }
    /**
     * Show the application dataKecamatan.
     *
     * @return \Illuminate\Http\Response
     */

}
