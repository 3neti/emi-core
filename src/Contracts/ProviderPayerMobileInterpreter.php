<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderPayerMobileInterpreter
{
    public function providerCode(): string;

    public function resolve(?string $institutionCode, ?string $accountNumber): ?string;
}
