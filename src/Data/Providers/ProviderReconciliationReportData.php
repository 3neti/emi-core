<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class ProviderReconciliationReportData extends Data
{
    /**
     * @param  list<string>  $exceptions
     */
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public string $settlementResourceReference,
        public DateTimeImmutable $checkedAt,
        public int $observedCount,
        public int $matchedCount,
        public array $exceptions = [],
    ) {}
}
