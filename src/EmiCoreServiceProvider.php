<?php

namespace LBHurtado\EmiCore;

use Illuminate\Support\ServiceProvider;
use LBHurtado\EmiCore\Contracts\BankRegistryContract;
use LBHurtado\EmiCore\Contracts\SettlementProviderRegistryContract;
use LBHurtado\EmiCore\Support\NullBankRegistry;
use LBHurtado\EmiCore\Support\SettlementProviderRegistry;

class EmiCoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/emi-core.php',
            'emi-core'
        );

        /**
         * Safe default so downstream packages can type against the contract
         * without requiring a concrete provider package to be installed.
         */
        $this->app->bindIf(BankRegistryContract::class, NullBankRegistry::class);

        $this->app->singleton(
            SettlementProviderRegistryContract::class,
            fn ($app): SettlementProviderRegistry => new SettlementProviderRegistry(
                $app->tagged('emi.settlement-providers'),
            ),
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
