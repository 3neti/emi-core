<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderCapabilityReadinessData;
use LBHurtado\EmiCore\Data\Providers\ProviderReadinessRequestData;

interface ProviderReadinessProbe extends SettlementProviderCapability
{
    public function checkReadiness(
        ProviderReadinessRequestData $request,
    ): ProviderCapabilityReadinessData;
}
