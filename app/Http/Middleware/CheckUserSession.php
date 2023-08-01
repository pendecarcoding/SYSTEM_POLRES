<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserSession
{

    public function handle($request, Closure $next)
    {
      if (!$request->session()->has('login','id_user','level')) {
          // user value cannot be found in session
            return redirect('/login')->with('alert','Kamu harus login dulu');

      }




        return $next($request);
    }



}
