<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderProvisioningGatewayFactory extends SettlementProviderCapability
{
    public function requiresLocalWallet(string $mode): bool;

    public function make(?ProviderSourceAccountReadiness $source = null): ProviderProvisioningGateway;
}
