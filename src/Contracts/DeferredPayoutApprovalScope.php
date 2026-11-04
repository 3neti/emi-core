<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use Closure;

interface DeferredPayoutApprovalScope
{
    public function providerCode(): string;

    public function isActiveProvider(): bool;

    public function requiresInteractiveApproval(): bool;

    public function run(Closure $callback): mixed;
}
