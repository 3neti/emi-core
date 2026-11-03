<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class ProviderFundingHistoryRequestData extends Data
{
    public function __construct(
        public string $provider,
        public string $reference,
        public string $connectionReference,
        public int $expectedAmountMinor,
        public string $currency,
        public DateTimeImmutable $observedAfter,
        public DateTimeImmutable $observedBefore,
    ) {}
}
