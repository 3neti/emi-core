<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderProvisioningProfile
{
    public function providerCode(): string;

    public function supportsMode(string $mode): bool;

    public function legacyBankAccountReference(?string $bankCode, ?string $maskedAccountNumber): ?string;

    public function legacyPrincipalReference(string $ownerKey, string $mode): string;
}
