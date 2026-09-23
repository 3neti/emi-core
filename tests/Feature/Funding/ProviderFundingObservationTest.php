<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Actions\Funding\RecordProviderFundingObservation;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Data\Funding\ProviderPayerIdentityData;
use LBHurtado\EmiCore\Exceptions\ImmutableProviderEvidence;
use LBHurtado\EmiCore\Models\ProviderFundingObservation;

function settledObservation(array $overrides = []): ProviderFundingObservationData
{
    return new ProviderFundingObservationData(...array_merge([
        'provider' => 'netbank',
        'providerTransactionId' => 'transaction-1001',
        'grossAmountMinor' => 100_00,
        'feeAmountMinor' => 50,
        'netAmountMinor' => 99_50,
        'currency' => 'php',
        'providerStatus' => 'Settled',
        'verificationSource' => 'transaction-query',
        'payloadHash' => hash('sha256', '{"transaction_id":"transaction-1001"}'),
        'providerOperationId' => 'operation-1001',
        'requestId' => 'intent-1001',
        'fundingAddress' => '123451234567',
        'providerAccountReference' => 'corporate-account-1',
        'occurredAt' => new DateTimeImmutable('2026-07-23T09:05:00+08:00'),
        'settledAt' => new DateTimeImmutable('2026-07-23T09:06:00+08:00'),
        'metadata' => ['rail' => 'instapay'],
    ], $overrides));
}

it('records append-only normalized funding observations idempotently', function () {
    $record = app(RecordProviderFundingObservation::class);

    $first = $record->handle(settledObservation());
    $retry = $record->handle(settledObservation());

    expect($retry->getKey())->toBe($first->getKey())
        ->and(ProviderFundingObservation::query()->count())->toBe(1)
        ->and($first->provider_code)->toBe('netbank')
        ->and($first->provider_status)->toBe('settled')
        ->and($first->currency)->toBe('PHP')
        ->and($first->gross_amount_minor)->toBe(100_00)
        ->and($first->fee_amount_minor)->toBe(50)
        ->and($first->net_amount_minor)->toBe(99_50)
        ->and($first->getRawOriginal('occurred_at'))->toBe('2026-07-23 01:05:00')
        ->and($first->getRawOriginal('settled_at'))->toBe('2026-07-23 01:06:00')
        ->and($first->occurredAtInstant()?->toRfc3339String())
        ->toBe('2026-07-23T01:05:00+00:00')
        ->and($first->settledAtInstant()?->toRfc3339String())
        ->toBe('2026-07-23T01:06:00+00:00');
});

it('encrypts provider-reported payer identity outside metadata', function () {
    $observation = app(RecordProviderFundingObservation::class)->handle(
        settledObservation([
            'payerIdentity' => new ProviderPayerIdentityData(
                name: 'Apple Hurtado',
                accountNumber: '09175180722',
                institutionCode: 'GXCHPHM2XXX',
                mobile: null,
                verificationSource: 'netbank-vca-transaction-history',
                providerVerified: false,
            ),
        ]),
    );
    $stored = DB::table('provider_funding_observations')
        ->where('id', $observation->getKey())
        ->sole();

    expect($observation->payer_name_ciphertext)->toBe('Apple Hurtado')
        ->and($observation->payer_account_ciphertext)->toBe('09175180722')
        ->and($observation->payer_institution_ciphertext)->toBe('GXCHPHM2XXX')
        ->and($observation->payer_mobile_ciphertext)->toBeNull()
        ->and($observation->payer_identity_verification_source)
        ->toBe('netbank-vca-transaction-history')
        ->and($observation->payer_identity_provider_verified)->toBeFalse()
        ->and($stored->payer_name_ciphertext)->not->toContain('Apple Hurtado')
        ->and($stored->payer_account_ciphertext)->not->toContain('09175180722')
        ->and($stored->payer_institution_ciphertext)->not->toContain('GXCHPHM2XXX')
        ->and($observation->metadata)->not->toHaveKeys([
            'payer_name',
            'payer_account',
            'payer_institution',
            'payer_mobile',
        ]);
});

it('preserves provider state transitions as separate observations', function () {
    $record = app(RecordProviderFundingObservation::class);

    $settled = $record->handle(settledObservation());
    $reversed = $record->handle(settledObservation([
        'providerStatus' => 'Reversed',
        'payloadHash' => hash('sha256', '{"status":"reversed"}'),
    ]));

    expect($reversed->getKey())->not->toBe($settled->getKey())
        ->and(ProviderFundingObservation::query()->count())->toBe(2);
});

it('preserves corrected normalization revisions as separate immutable observations', function () {
    $record = app(RecordProviderFundingObservation::class);

    $legacy = $record->handle(settledObservation());
    $corrected = $record->handle(settledObservation([
        'feeAmountMinor' => 0,
        'netAmountMinor' => 100_00,
        'metadata' => [
            'rail' => 'instapay',
            'normalization_version' => 'netbank-standing-credit-v2',
        ],
    ]));
    $retry = $record->handle(settledObservation([
        'feeAmountMinor' => 0,
        'netAmountMinor' => 100_00,
        'metadata' => [
            'rail' => 'instapay',
            'normalization_version' => 'netbank-standing-credit-v2',
        ],
    ]));

    expect($corrected->getKey())->not->toBe($legacy->getKey())
        ->and($retry->getKey())->toBe($corrected->getKey())
        ->and($legacy->fee_amount_minor)->toBe(50)
        ->and($corrected->fee_amount_minor)->toBe(0)
        ->and(ProviderFundingObservation::query()->count())->toBe(2);
});

it('rejects unsafe normalization revision identifiers', function () {
    expect(fn () => app(RecordProviderFundingObservation::class)->handle(
        settledObservation([
            'metadata' => ['normalization_version' => 'NetBank V2'],
        ]),
    ))->toThrow(InvalidArgumentException::class, 'safe lowercase identifier');
});

it('makes normalized observations immutable', function () {
    $observation = app(RecordProviderFundingObservation::class)
        ->handle(settledObservation());

    expect(fn () => $observation->update(['net_amount_minor' => 1]))
        ->toThrow(ImmutableProviderEvidence::class)
        ->and(fn () => $observation->delete())
        ->toThrow(ImmutableProviderEvidence::class);
});

it('rejects impossible normalized amounts before recording evidence', function () {
    expect(fn () => app(RecordProviderFundingObservation::class)->handle(
        settledObservation(['netAmountMinor' => 101_00]),
    ))->toThrow(InvalidArgumentException::class, 'cannot exceed the gross amount');
});
