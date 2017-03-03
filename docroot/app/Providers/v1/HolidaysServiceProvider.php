<?php

namespace App\Providers\v1;

use App\Services\v1;
use Illuminate\Support\ServiceProvider;

class HolidaysServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(HolidayService::class, function($app){
            return new HolidayService();
        });
    }
}
