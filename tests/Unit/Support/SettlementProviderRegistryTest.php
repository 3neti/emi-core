<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Contracts\SettlementProvider;
use LBHurtado\EmiCore\Contracts\SettlementProviderRegistryContract;
use LBHurtado\EmiCore\Data\Providers\ProviderCapabilityManifestData;
use LBHurtado\EmiCore\Enums\ProviderCapability;
use LBHurtado\EmiCore\Exceptions\DuplicateSettlementProvider;
use LBHurtado\EmiCore\Exceptions\UnknownSettlementProvider;
use LBHurtado\EmiCore\Support\SettlementProviderRegistry;

it('indexes provider manifests and resolves capabilities case insensitively', function () {
    $registry = new SettlementProviderRegistry([
        providerManifest('future_emi', [
            ProviderCapability::BalanceRead,
            ProviderCapability::Reconciliation,
        ]),
        providerManifest('netbank', [
            ProviderCapability::FundingEvidenceRead,
        ]),
    ]);

    expect(array_keys($registry->all()))->toBe(['future_emi', 'netbank'])
        ->and($registry->has(' NETBANK '))->toBeTrue()
        ->and($registry->supports('future_emi', ProviderCapability::Reconciliation))->toBeTrue()
        ->and($registry->supports('netbank', ProviderCapability::BalanceRead))->toBeFalse();
});

it('fails fast when a provider code is registered twice', function () {
    expect(fn () => new SettlementProviderRegistry([
        providerManifest('netbank'),
        providerManifest('netbank'),
    ]))->toThrow(DuplicateSettlementProvider::class);
});

it('fails explicitly when an unknown provider is requested', function () {
    $registry = new SettlementProviderRegistry([]);

    expect(fn () => $registry->get('not-installed'))
        ->toThrow(UnknownSettlementProvider::class, 'not-installed');
});

it('resolves an empty registry safely when no provider packages are installed', function () {
    $registry = app(SettlementProviderRegistryContract::class);

    expect($registry)->toBeInstanceOf(SettlementProviderRegistry::class)
        ->and($registry->all())->toBe([]);
});

/**
 * @param  list<ProviderCapability>  $capabilities
 */
function providerManifest(
    string $provider,
    array $capabilities = [],
): SettlementProvider {
    return new class($provider, $capabilities) implements SettlementProvider
    {
        /**
         * @param  list<ProviderCapability>  $capabilities
         */
        public function __construct(
            private readonly string $provider,
            private readonly array $capabilities,
        ) {}

        public function manifest(): ProviderCapabilityManifestData
        {
            return new ProviderCapabilityManifestData(
                provider: $this->provider,
                label: ucfirst($this->provider),
                capabilities: $this->capabilities,
            );
        }
    };
}
