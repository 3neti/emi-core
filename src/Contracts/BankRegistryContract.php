<?php

namespace LBHurtado\EmiCore\Contracts;

interface BankRegistryContract
{
    public function isEMI(string $bankCode): bool;
    public function getBankName(string $bankCode): string;
    public function getBankLogo(string $bankCode): ?string;
}