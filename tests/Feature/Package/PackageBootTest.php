<?php

use LBHurtado\EmiCore\EmiCoreServiceProvider;
use LBHurtado\EmiCore\Models\ProviderAccount;

it('boots the emi-core service provider', function () {
    expect(app()->getProviders(EmiCoreServiceProvider::class))
        ->not->toBeEmpty();
});

it('loads the emi-core config', function () {
    expect(config('emi-core.default_provider'))
        ->toBeNull('default_provider should be null — host app sets it');
});

it('auto-loads only the funding evidence migrations required by settlement packages', function () {
    $migrationPaths = array_map(
        static fn (string $path): string|false => realpath($path),
        app('migrator')->paths(),
    );

    expect($migrationPaths)
        ->toContain(
            realpath(__DIR__.'/../../../database/migrations/2025_01_01_000008_create_webhook_receipts_table.php'),
            realpath(__DIR__.'/../../../database/migrations/2026_07_23_085518_create_provider_funding_observations_table.php'),
            realpath(__DIR__.'/../../../database/migrations/2026_07_23_085520_harden_emi_webhook_receipts_for_funding_evidence.php'),
        )
        ->not->toContain(
            realpath(__DIR__.'/../../../database/migrations/2025_01_01_000002_create_wallets_table.php'),
        );
});

it('can create a provider account', function () {
    $account = ProviderAccount::create([
        'provider_code' => 'paynamics_constellation',
        'name' => 'Test Account',
        'merchant_id' => 'TEST123',
        'integration_key' => 'test-key',
        'base_url' => 'https://example.com',
        'is_active' => true,
    ]);

    expect($account)->toBeInstanceOf(ProviderAccount::class)
        ->and($account->provider_code->value)->toBe('paynamics_constellation')
        ->and($account->is_active)->toBeTrue();
});
