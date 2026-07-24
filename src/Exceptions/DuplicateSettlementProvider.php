<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Exceptions;

use LogicException;

final class DuplicateSettlementProvider extends LogicException
{
    public static function for(string $provider): self
    {
        return new self("Settlement provider [{$provider}] is registered more than once.");
    }
}
