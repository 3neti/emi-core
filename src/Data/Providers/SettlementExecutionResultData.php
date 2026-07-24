<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class SettlementExecutionResultData extends Data
{
    public function __construct(
        public string $provider,
        public string $instructionReference,
        public string $providerTransactionReference,
        public string $status,
        public DateTimeImmutable $observedAt,
    ) {}
}
