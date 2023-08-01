<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         app_path() . '/Helpers/Helper.php';
         $this->app->bind(
            'App\Http\Interfaces\PegawaiInterfaces',
            'App\Http\Repository\PegawaiRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
