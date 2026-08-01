<?php

namespace LBHurtado\EmiCore;

use Illuminate\Support\ServiceProvider;
use LBHurtado\EmiCore\Contracts\BankRegistryContract;
use LBHurtado\EmiCore\Contracts\SettlementProviderRegistryContract;
use LBHurtado\EmiCore\Support\NullBankRegistry;
use LBHurtado\EmiCore\Support\SettlementProviderRegistry;

class EmiCoreServiceProvider extends ServiceProvider
{
    /**
     * Funding evidence tables are safe to auto-load and are required by
     * downstream settlement packages during an ordinary Laravel migration.
     *
     * @var list<string>
     */
    private const AUTO_LOADED_MIGRATIONS = [
        '2025_01_01_000008_create_webhook_receipts_table.php',
        '2026_07_23_085518_create_provider_funding_observations_table.php',
        '2026_07_23_085520_harden_emi_webhook_receipts_for_funding_evidence.php',
    ];

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
        $this->loadMigrationsFrom(array_map(
            static fn (string $migration): string => __DIR__.'/../database/migrations/'.$migration,
            self::AUTO_LOADED_MIGRATIONS,
        ));

        // Migrations are publishable, not auto-loaded, to avoid table conflicts
        // for the provider-account ledger (e.g. emi-core 'wallets' vs Bavix Wallet 'wallets').
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'emi-core-migrations');

        $this->publishes([
            __DIR__.'/../config/emi-core.php' => config_path('emi-core.php'),
        ], 'emi-core-config');
    }
}
