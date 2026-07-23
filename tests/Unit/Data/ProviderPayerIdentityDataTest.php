<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Data\Funding\ProviderPayerIdentityData;

it('carries optional provider payer identity without making it settlement authority', function () {
    $identity = new ProviderPayerIdentityData(
        mobile: '+639171234567',
        verificationSource: 'simulated-qrph-payer-profile',
        providerVerified: true,
    );

    $observation = new ProviderFundingObservationData(
        provider: 'qrph_simulator',
        providerTransactionId: 'simulated-transaction-123',
        grossAmountMinor: 2_500,
        feeAmountMinor: 0,
        netAmountMinor: 2_500,
        currency: 'PHP',
        providerStatus: 'settled',
        verificationSource: 'simulated-provider-ledger',
        payloadHash: hash('sha256', 'simulated-provider-observation'),
        payerIdentity: $identity,
    );

    expect($observation->payerIdentity)->toBe($identity)
        ->and($observation->payerIdentity?->mobile)->toBe('+639171234567')
        ->and($observation->payerIdentity?->providerVerified)->toBeTrue()
        ->and($observation->payerIdentity?->verificationSource)
        ->toBe('simulated-qrph-payer-profile');
});

it('keeps payer identity optional for existing provider adapters', function () {
    $observation = new ProviderFundingObservationData(
        provider: 'netbank',
        providerTransactionId: 'transaction-123',
        grossAmountMinor: 2_500,
        feeAmountMinor: 0,
        netAmountMinor: 2_500,
        currency: 'PHP',
        providerStatus: 'settled',
        verificationSource: 'netbank-vca-transaction-history',
        payloadHash: hash('sha256', 'netbank-provider-observation'),
    );

    expect($observation->payerIdentity)->toBeNull();
});
