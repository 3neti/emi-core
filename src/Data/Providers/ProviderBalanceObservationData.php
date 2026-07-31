<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class ProviderBalanceObservationData extends Data
{
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public string $currency,
        public int $balanceMinor,
        public DateTimeImmutable $observedAt,
        public ?string $providerReference = null,
    ) {}
}
