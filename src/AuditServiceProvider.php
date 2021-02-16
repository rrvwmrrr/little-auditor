<?php

namespace Rrvwmrrr\Auditor;

use Illuminate\Support\ServiceProvider;

class AuditServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([
            __DIR__.'/../config/little-auditor.php' => config_path('little-auditor.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../config/little-auditor.php', 'little-auditor'
        );
    }
}
