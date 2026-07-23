<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Exceptions;

use RuntimeException;

class ProviderEvidenceConflict extends RuntimeException
{
    public static function changedBody(string $provider, string $providerEventId): self
    {
        return new self(sprintf(
            'Provider event [%s:%s] was received with a different body.',
            $provider,
            $providerEventId,
        ));
    }
}
