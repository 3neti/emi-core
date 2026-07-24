<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class ProviderReconciliationRequestData extends Data
{
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public string $settlementResourceReference,
        public DateTimeImmutable $from,
        public DateTimeImmutable $until,
    ) {}
}
