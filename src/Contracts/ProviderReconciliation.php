<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderReconciliationReportData;
use LBHurtado\EmiCore\Data\Providers\ProviderReconciliationRequestData;

interface ProviderReconciliation extends SettlementProviderCapability
{
    public function reconcile(
        ProviderReconciliationRequestData $request,
    ): ProviderReconciliationReportData;
}
