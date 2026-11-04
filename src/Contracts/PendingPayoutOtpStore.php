<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface PendingPayoutOtpStore
{
    /** @param array<string, mixed> $request */
    public function getSubmittedOtp(array $request): ?string;

    /** @param array<string, mixed> $request @param array<string, mixed> $result */
    public function putPendingOtp(array $request, array $result): void;
}
