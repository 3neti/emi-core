<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderClaimantBankProvisioningPolicy
{
    public function requiresClaimantBankProvisioning(): bool;
}
