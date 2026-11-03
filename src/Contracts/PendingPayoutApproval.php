<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use Throwable;

interface PendingPayoutApproval extends Throwable
{
    public function provider(): string;

    public function requestId(): ?string;

    /** @return array<string, mixed> */
    public function toApprovalMetadata(): array;
}
