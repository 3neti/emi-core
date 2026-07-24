<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use Spatie\LaravelData\Data;

class SettlementExecutionRequestData extends Data
{
    /**
     * @param  array<string, scalar|null>  $destination
     */
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public string $settlementResourceReference,
        public string $instructionReference,
        public int $amountMinor,
        public string $currency,
        public string $idempotencyKey,
        public array $destination,
    ) {}
}
