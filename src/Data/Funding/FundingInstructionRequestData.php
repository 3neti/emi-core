<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class FundingInstructionRequestData extends Data
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function __construct(
        public string $provider,
        public string $fundingReference,
        public int $amountMinor,
        public string $currency,
        public string $accountReference,
        public ?DateTimeImmutable $expiresAt = null,
        public array $metadata = [],
    ) {}
}
