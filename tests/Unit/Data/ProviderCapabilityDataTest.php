<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Providers\ProviderBalanceObservationData;
use LBHurtado\EmiCore\Data\Providers\ProviderCapabilityManifestData;
use LBHurtado\EmiCore\Data\Providers\ProviderCapabilityReadinessData;
use LBHurtado\EmiCore\Enums\ProviderCapability;

it('accepts arbitrary canonical providers and deduplicates declared capabilities', function () {
    $manifest = new ProviderCapabilityManifestData(
        provider: ' Future_EMI ',
        label: 'Future EMI',
        capabilities: [
            ProviderCapability::BalanceRead,
            ProviderCapability::BalanceRead,
            ProviderCapability::Reconciliation,
        ],
    );

    expect($manifest->provider)->toBe('future_emi')
        ->and($manifest->capabilities)->toHaveCount(2)
        ->and($manifest->supports(ProviderCapability::BalanceRead))->toBeTrue()
        ->and($manifest->supports(ProviderCapability::SettlementExecution))->toBeFalse();
});

it('rejects provider codes that cannot be used as canonical registry keys', function () {
    expect(fn () => new ProviderCapabilityManifestData(
        provider: 'Future EMI!',
        label: 'Future EMI',
        capabilities: [],
    ))->toThrow(InvalidArgumentException::class, 'canonical lower-case identifiers');
});

it('evaluates readiness only for the capabilities requested by a connection', function () {
    $readiness = new ProviderCapabilityReadinessData(
        provider: 'netbank',
        connectionReference: 'netbank-primary',
        checks: [
            ProviderCapability::BalanceRead->value => true,
            ProviderCapability::SettlementExecution->value => false,
        ],
        issues: [
            ProviderCapability::SettlementExecution->value => ['Settlement credentials are unavailable.'],
        ],
        checkedAt: new DateTimeImmutable('2026-07-24T10:00:00+08:00'),
    );

    expect($readiness->readyFor([ProviderCapability::BalanceRead]))->toBeTrue()
        ->and($readiness->readyFor([
            ProviderCapability::BalanceRead,
            ProviderCapability::SettlementExecution,
        ]))->toBeFalse();
});

it('represents provider liquidity in integer minor units with opaque evidence', function () {
    $observation = new ProviderBalanceObservationData(
        provider: 'netbank',
        connectionReference: 'netbank-primary',
        settlementResourceReference: 'resource:netbank:primary:php',
        amountMinor: 200_000_000,
        currency: 'PHP',
        observedAt: new DateTimeImmutable('2026-07-24T10:00:00+08:00'),
        evidenceReference: 'balance-observation:sha256:abc123',
    );

    expect($observation->amountMinor)->toBeInt()->toBe(200_000_000)
        ->and($observation->evidenceReference)->not->toContain('account-number');
});
