<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderWalletBalanceData;

interface ProviderWalletBalanceReader
{
    public function providerCode(): string;

    public function readWalletBalance(string $walletId, string $fallbackCurrency): ProviderWalletBalanceData;
}
