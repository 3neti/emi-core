<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface PayoutProviderIdentity extends SettlementProviderCapability
{
    public function acceptsPayoutProvider(string $provider): bool;
}
