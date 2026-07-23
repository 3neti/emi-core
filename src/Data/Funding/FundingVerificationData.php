<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class FundingVerificationData extends Data
{
    public function __construct(
        public string $provider,
        public string $fundingIntentReference,
        public int $expectedAmountMinor,
        public string $currency,
        public ?string $providerRequestId = null,
        public ?string $fundingAddress = null,
        public ?int $webhookReceiptId = null,
    ) {}
}
