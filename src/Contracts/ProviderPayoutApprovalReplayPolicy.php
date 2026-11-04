<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use Closure;
use Throwable;

interface ProviderPayoutApprovalReplayPolicy extends SettlementProviderCapability
{
    public function supportsProvider(string $provider): bool;

    /** @param array<string, mixed> $payload @param Closure(): array<string, mixed> $metadata */
    public function shouldResume(array $payload, Closure $metadata, Throwable $exception): bool;
}
