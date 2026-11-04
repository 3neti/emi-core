<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderCommissioningFingerprintInputs
{
    /** @return array<string, mixed> */
    public function settlementAccountFingerprintInputs(): array;
}
