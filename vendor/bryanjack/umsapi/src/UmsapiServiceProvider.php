<?php

namespace Bryanjack\Umsapi;

use Bryanjack\Umsapi\App\Commands\UmsapiInstall;
use Bryanjack\Umsapi\App\Commands\UpdateKaryawan;
use Illuminate\Support\ServiceProvider;

class UmsapiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'umsapi');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        // $this->publishes([
        //     __DIR__ . '/public' => public_path('vendor/bryanjack/umsapi'),
        // ]);

        $this->commands([
            UmsapiInstall::class,
            UpdateKaryawan::class,
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/main.php', 'core');
    }
}
