<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderSourceAccountReadinessRequestData;

interface ProviderSourceAccountReadiness extends SettlementProviderCapability
{
    /** @return array<string, mixed>|null */
    public function inspectSourceAccount(ProviderSourceAccountReadinessRequestData $request): ?array;
}
