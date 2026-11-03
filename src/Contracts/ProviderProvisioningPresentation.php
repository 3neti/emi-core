<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderProvisioningPresentation extends SettlementProviderCapability
{
    public function defaultProvisioningTopology(): string;

    /** @return array<string, mixed>|null */
    public function provisioningPresentation(string $mode): ?array;
}
