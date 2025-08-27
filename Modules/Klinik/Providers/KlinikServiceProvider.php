<?php

namespace Modules\Klinik\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Klinik\App\Services\KfaDrugSyncService;
use Modules\Klinik\App\Services\StringSimilarityService;

class KlinikServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(StringSimilarityService::class, function () {
            return new StringSimilarityService();
        });

        $this->app->singleton(KfaDrugSyncService::class, function ($app) {
            return new KfaDrugSyncService($app->make(StringSimilarityService::class));
        });
    }

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('Klinik', '/Database/Migrations'));
        $this->loadRoutesFrom(module_path('Klinik', '/Routes/web.php'));
        $this->loadViewsFrom(module_path('Klinik', '/Resources/views'), 'klinik');
        $this->loadTranslationsFrom(module_path('Klinik', '/Resources/lang'), 'klinik');
        
        // Daftarkan commands secara manual
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Modules\Klinik\Console\Commands\SyncKfaDrugsCommand::class,
            ]);
        }
    }
}