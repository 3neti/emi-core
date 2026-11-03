<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderWalletProjectionSynchronizer extends SettlementProviderCapability
{
    /** @return array<string, mixed> */
    public function handle(string $walletId, mixed $owner = null): array;

    public function configuredWalletIdForOwner(mixed $owner): ?string;
}
