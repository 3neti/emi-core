<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use LBHurtado\EmiCore\Enums\FundingAddressPurpose;
use Spatie\LaravelData\Data;

class StandingFundingObservationRequestData extends Data
{
    public function __construct(
        public string $fundingAddress,
        public string $accountReference,
        public FundingAddressPurpose $purpose,
        public string $currency,
        public string $verificationSource,
        public ?FundingDestinationData $destination = null,
        public ?int $webhookReceiptId = null,
    ) {}
}
