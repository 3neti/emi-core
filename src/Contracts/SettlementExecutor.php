<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\SettlementExecutionRequestData;
use LBHurtado\EmiCore\Data\Providers\SettlementExecutionResultData;

interface SettlementExecutor extends SettlementProviderCapability
{
    public function executeSettlement(
        SettlementExecutionRequestData $request,
    ): SettlementExecutionResultData;
}
