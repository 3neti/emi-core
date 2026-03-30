<?php

use LBHurtado\EmiCore\Enums\ComplianceLevel;
use LBHurtado\EmiCore\Enums\ProviderCode;
use LBHurtado\EmiCore\Enums\VerificationStatus;
use LBHurtado\EmiCore\Enums\WalletStatus;
use LBHurtado\EmiCore\Enums\WalletType;
use LBHurtado\EmiCore\Models\ProviderAccount;
use LBHurtado\EmiCore\Models\Wallet;
use LBHurtado\EmiCore\Models\WalletLimitSnapshot;
use LBHurtado\EmiCore\Models\WalletProfile;

it('can create a wallet with all fields', function () {
    $wallet = Wallet::create([
        'provider_code' => 'paynamics_constellation',
        'provider_wallet_id' => 'CNSTWLLTABCDEF',
        'provider_account_id_value' => 'CNSTCSTMR12345',
        'account_no' => '071127093068',
        'external_uid' => 'ext-uid-123',
        'wallet_type' => 'customer',
        'status' => 'active',
        'compliance_level' => '1',
        'verification_status' => 'APPROVED',
        'balance_cached' => 1000.50,
        'currency' => 'PHP',
    ]);

    expect($wallet->provider_code)->toBe(ProviderCode::PaynamicsConstellation)
        ->and($wallet->wallet_type)->toBe(WalletType::Customer)
        ->and($wallet->status)->toBe(WalletStatus::Active)
        ->and($wallet->compliance_level)->toBe(ComplianceLevel::Level1)
        ->and($wallet->verification_status)->toBe(VerificationStatus::Approved)
        ->and($wallet->balance_cached)->toBe('1000.50');
});

it('has a profile relationship', function () {
    $wallet = Wallet::create([
        'provider_code' => 'paynamics_constellation',
        'provider_wallet_id' => 'CNSTWLLT000001',
        'wallet_type' => 'customer',
    ]);

    $wallet->profile()->create([
        'first_name' => 'Juan',
        'last_name' => 'Dela Cruz',
        'email' => 'juan@example.com',
        'mobile_no' => '639171234567',
    ]);

    expect($wallet->profile)->toBeInstanceOf(WalletProfile::class)
        ->and($wallet->profile->first_name)->toBe('Juan');
});

it('has limit snapshots', function () {
    $wallet = Wallet::create([
        'provider_code' => 'paynamics_constellation',
        'provider_wallet_id' => 'CNSTWLLT000002',
        'wallet_type' => 'merchant',
    ]);

    $wallet->limitSnapshots()->create([
        'remaining_wallet_limit' => 50000.00,
        'remaining_inflow_limit' => 95000.00,
        'captured_at' => now(),
    ]);

    expect($wallet->limitSnapshots)->toHaveCount(1)
        ->and($wallet->limitSnapshots->first())->toBeInstanceOf(WalletLimitSnapshot::class);
});

it('belongs to a provider account', function () {
    $account = ProviderAccount::create([
        'provider_code' => 'paynamics_constellation',
        'name' => 'Test Provider',
    ]);

    $wallet = Wallet::create([
        'provider_account_id' => $account->id,
        'provider_code' => 'paynamics_constellation',
        'provider_wallet_id' => 'CNSTWLLT000003',
        'wallet_type' => 'customer',
    ]);

    expect($wallet->providerAccount)->toBeInstanceOf(ProviderAccount::class)
        ->and($wallet->providerAccount->name)->toBe('Test Provider');
});
