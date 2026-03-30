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
