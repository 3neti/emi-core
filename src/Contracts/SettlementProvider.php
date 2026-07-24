<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderCapabilityManifestData;

interface SettlementProvider
{
    public function manifest(): ProviderCapabilityManifestData;
}
