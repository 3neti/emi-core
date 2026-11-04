<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Enums\SettlementRail;

interface ProviderSettlementRailConfiguration extends SettlementProviderCapability
{
    /** @return array<string, mixed> */
    public function configurationFor(SettlementRail $rail): array;
}
