<?php

namespace LBHurtado\EmiCore\Support;

use LBHurtado\EmiCore\Contracts\BankRegistryContract;
use LBHurtado\EmiCore\Enums\SettlementRail;

class NullBankRegistry implements BankRegistryContract
{
    public function isEMI(string $bankCode): bool
    {
        return false;
    }

    public function getBankName(string $bankCode): string
    {
        return $bankCode;
    }

    public function getBankLogo(string $bankCode): ?string
    {
        return null;
    }

    public function supportsRail(string $bankCode, SettlementRail $rail): bool
    {
        return false;
    }
}