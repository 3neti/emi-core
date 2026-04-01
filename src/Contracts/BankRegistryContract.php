<?php

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Enums\SettlementRail;

interface BankRegistryContract
{
    public function isEMI(string $bankCode): bool;
    public function getBankName(string $bankCode): string;
    public function getBankLogo(string $bankCode): ?string;

    public function supportsRail(string $bankCode, SettlementRail $rail): bool;
}