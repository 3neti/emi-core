<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Support;

use LBHurtado\EmiCore\Contracts\SettlementProvider;
use LBHurtado\EmiCore\Contracts\SettlementProviderRegistryContract;
use LBHurtado\EmiCore\Data\Providers\ProviderCapabilityManifestData;
use LBHurtado\EmiCore\Enums\ProviderCapability;
use LBHurtado\EmiCore\Exceptions\DuplicateSettlementProvider;
use LBHurtado\EmiCore\Exceptions\UnknownSettlementProvider;

final class SettlementProviderRegistry implements SettlementProviderRegistryContract
{
    /** @var array<string, ProviderCapabilityManifestData> */
    private array $providers = [];

    /**
     * @param  iterable<SettlementProvider>  $providers
     */
    public function __construct(iterable $providers)
    {
        foreach ($providers as $provider) {
            $manifest = $provider->manifest();

            if (isset($this->providers[$manifest->provider])) {
                throw DuplicateSettlementProvider::for($manifest->provider);
            }

            $this->providers[$manifest->provider] = $manifest;
        }

        ksort($this->providers);
    }

    public function all(): array
    {
        return $this->providers;
    }

    public function has(string $provider): bool
    {
        return isset($this->providers[$this->normalize($provider)]);
    }

    public function get(string $provider): ProviderCapabilityManifestData
    {
        $provider = $this->normalize($provider);

        return $this->providers[$provider]
            ?? throw UnknownSettlementProvider::for($provider);
    }

    public function supports(string $provider, ProviderCapability $capability): bool
    {
        return $this->get($provider)->supports($capability);
    }

    private function normalize(string $provider): string
    {
        return mb_strtolower(trim($provider));
    }
}
