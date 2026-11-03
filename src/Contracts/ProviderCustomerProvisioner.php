<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderCustomerProvisioner
{
    public function providerCode(): string;

    /** @param array<string, mixed> $request @return array<string, mixed> */
    public function createCustomerWallet(array $request): array;

    /** @return array<string, mixed> */
    public function readWallet(string $identifier): array;

    /** @param array<string, mixed> $request @return array<string, mixed> */
    public function linkBankAccount(array $request): array;

    /** @param array<string, mixed> $request @return array<string, mixed> */
    public function createIdentityVerificationLink(array $request): array;
}
