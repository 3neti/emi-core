<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Providers\ProviderLivePreflightResultData;
use LBHurtado\EmiCore\Enums\ProviderLivePreflightFailureCode;

it('exposes the provider-neutral sanitized live preflight failure taxonomy', function () {
    expect(array_column(ProviderLivePreflightFailureCode::cases(), 'value'))
        ->toBe([
            'dns_resolution_failed',
            'connection_timeout',
            'tls_failure',
            'authentication_failed',
            'balance_endpoint_rejected',
            'invalid_balance_response',
            'provider_unavailable',
        ]);
});

it('serializes a live preflight failure without provider secrets', function () {
    $result = new ProviderLivePreflightResultData(
        provider: 'example',
        connectionReference: 'example-primary',
        ready: false,
        checkedAt: new DateTimeImmutable('2026-07-29T09:30:00+08:00'),
        failureCode: ProviderLivePreflightFailureCode::AuthenticationFailed,
    );

    expect($result->toArray())->toMatchArray([
        'provider' => 'example',
        'connectionReference' => 'example-primary',
        'ready' => false,
        'failureCode' => 'authentication_failed',
    ]);
});
