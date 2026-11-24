<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use Spatie\LaravelData\Data;

class AccountTransferEvidenceData extends Data
{
    public function __construct(
        public readonly string $reference,
        public readonly string $sourceAccountNumber,
        public readonly string $destinationAccountNumber,
        public readonly string $sourceCustomerId,
        public readonly int $amountMinor,
        public readonly string $currency,
        public readonly string $rail,
        public readonly int $feeMinor,
    ) {}
}
