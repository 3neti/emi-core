<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Configuration\EnvironmentVariableData;

it('evaluates environment requirements from profiles and provider codes', function (): void {
    $variable = new EnvironmentVariableData(
        key: 'NETBANK_API_TOKEN',
        description: 'Provider API token.',
        category: 'NetBank',
        secret: true,
        requiredForProfiles: ['netbank'],
        requiredForProviders: ['netbank'],
    );

    expect($variable->isRequired('netbank', []))->toBeTrue()
        ->and($variable->isRequired('custom', ['netbank']))->toBeTrue()
        ->and($variable->isRequired('development', []))->toBeFalse();
});

it('rejects unsafe secret examples', function (): void {
    expect(fn () => new EnvironmentVariableData(
        key: 'NETBANK_API_TOKEN',
        description: 'Provider API token.',
        category: 'NetBank',
        safeExample: 'real-looking-secret',
        secret: true,
    ))->toThrow(InvalidArgumentException::class);
});

it('rejects invalid keys and incomplete descriptions', function (): void {
    expect(fn () => new EnvironmentVariableData(
        key: 'netbank-token',
        description: 'Token.',
        category: 'NetBank',
    ))->toThrow(InvalidArgumentException::class)
        ->and(fn () => new EnvironmentVariableData(
            key: 'NETBANK_TOKEN',
            description: '',
            category: 'NetBank',
        ))->toThrow(InvalidArgumentException::class);
});
