<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface PendingPayoutOtpInterpreter extends SettlementProviderCapability
{
    /** @param array<string, mixed> $request */
    public function reference(array $request): ?string;

    /** @param array<string, mixed> $request @param array<string, mixed> $result @return array<string, mixed> */
    public function pendingMetadata(array $request, array $result): array;
}
