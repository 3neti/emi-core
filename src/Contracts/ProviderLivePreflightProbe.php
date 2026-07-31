<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderLivePreflightRequestData;
use LBHurtado\EmiCore\Data\Providers\ProviderLivePreflightResultData;

interface ProviderLivePreflightProbe extends SettlementProviderCapability
{
    public function checkLiveReadiness(
        ProviderLivePreflightRequestData $request,
    ): ProviderLivePreflightResultData;
}
