<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderBalanceObservationData;
use LBHurtado\EmiCore\Data\Providers\ProviderBalanceRequestData;

interface ProviderBalanceReader extends SettlementProviderCapability
{
    public function readBalance(
        ProviderBalanceRequestData $request,
    ): ProviderBalanceObservationData;
}
