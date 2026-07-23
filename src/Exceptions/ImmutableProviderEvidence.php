<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Exceptions;

use LogicException;

class ImmutableProviderEvidence extends LogicException
{
    public static function receipt(): self
    {
        return new self('Provider webhook evidence is immutable after receipt.');
    }

    public static function observation(): self
    {
        return new self('Provider funding observations are append-only.');
    }
}
