<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderDefaultProvisioningMode extends SettlementProviderCapability
{
    public function defaultProvisioningMode(): string;
}
