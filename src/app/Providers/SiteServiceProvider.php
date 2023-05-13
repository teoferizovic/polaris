<?php

namespace App\Providers;

use App\Repo\SiteRepo;
use Illuminate\Support\ServiceProvider;

class SiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*$this->app->bind('SiteRepo', function($app) {
            return new SiteRepo('test');
        });*/

        $this->app->singleton(SiteRepo::class, function($app){       
            return new SiteRepo('usd');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
