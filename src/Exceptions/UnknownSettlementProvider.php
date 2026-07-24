<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Exceptions;

use RuntimeException;

final class UnknownSettlementProvider extends RuntimeException
{
    public static function for(string $provider): self
    {
        return new self("Settlement provider [{$provider}] is not registered.");
    }
}
