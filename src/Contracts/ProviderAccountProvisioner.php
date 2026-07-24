<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderAccountProvisioningRequestData;
use LBHurtado\EmiCore\Data\Providers\ProviderAccountProvisioningResultData;

interface ProviderAccountProvisioner extends SettlementProviderCapability
{
    public function provisionProviderAccount(
        ProviderAccountProvisioningRequestData $request,
    ): ProviderAccountProvisioningResultData;
}
