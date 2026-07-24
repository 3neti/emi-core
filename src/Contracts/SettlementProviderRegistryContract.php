<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderCapabilityManifestData;
use LBHurtado\EmiCore\Enums\ProviderCapability;

interface SettlementProviderRegistryContract
{
    /**
     * @return array<string, ProviderCapabilityManifestData>
     */
    public function all(): array;

    public function has(string $provider): bool;

    public function get(string $provider): ProviderCapabilityManifestData;

    public function supports(string $provider, ProviderCapability $capability): bool;
}
