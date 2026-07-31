<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface SettlementProviderCapability
{
    public function providerCode(): string;
}
