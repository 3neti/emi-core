<?php

namespace LBHurtado\EmiCore;

use Illuminate\Support\ServiceProvider;

class EmiCoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/emi-core.php',
            'emi-core'
        );
    }

    public function boot(): void
    {
        // Migrations are publishable, not auto-loaded, to avoid table conflicts
        // (e.g. emi-core 'wallets' vs Bavix Wallet 'wallets')
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'emi-core-migrations');

        $this->publishes([
            __DIR__.'/../config/emi-core.php' => config_path('emi-core.php'),
        ], 'emi-core-config');
    }
}
