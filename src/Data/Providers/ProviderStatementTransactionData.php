<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class ProviderStatementTransactionData extends Data
{
    public function __construct(
        public string $transactionId,
        public string $direction,
        public string $amountMinor,
        public string $currency,
        public string $status,
        public DateTimeImmutable $occurredAt,
    ) {}
}
