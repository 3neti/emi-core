<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Exceptions;

use LBHurtado\EmiCore\Enums\ProviderLivePreflightFailureCode;
use RuntimeException;

final class ProviderLivePreflightFailed extends RuntimeException
{
    public function __construct(
        public readonly ProviderLivePreflightFailureCode $failureCode,
    ) {
        parent::__construct(
            "Provider live preflight failed [{$failureCode->value}].",
        );
    }
}
