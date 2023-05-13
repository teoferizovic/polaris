<?php

namespace App\Providers;

use App\Repo\SiteRepo;
use App\Repo\SiteRepo2;
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

        $this->app->singleton(SiteRepo2::class, function($app){       
            return new SiteRepo2('kk');
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
