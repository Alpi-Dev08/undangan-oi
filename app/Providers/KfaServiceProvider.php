<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\KfaService;
use Modules\Klinik\App\Http\Controllers\KfaController;

class KfaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(KfaService::class, function ($app) {
            return new KfaService($app->make(KfaController::class));
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