<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class FundingInstructionsData extends Data
{
    /**
     * @param  array<string, mixed>  $displayData
     */
    public function __construct(
        public string $provider,
        public string $providerReference,
        public int $amountMinor,
        public string $currency,
        public ?DateTimeImmutable $expiresAt = null,
        public ?string $fundingAddress = null,
        public ?string $actionUrl = null,
        public array $displayData = [],
        public ?FundingQrCodeData $qrCode = null,
    ) {}
}
