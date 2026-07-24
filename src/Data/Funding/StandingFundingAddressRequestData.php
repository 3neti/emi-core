<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use LBHurtado\EmiCore\Enums\FundingAddressPurpose;
use Spatie\LaravelData\Data;

class StandingFundingAddressRequestData extends Data
{
    public function __construct(
        public string $ownerReference,
        public string $accountReference,
        public FundingAddressPurpose $purpose,
        public string $currency,
        public ?FundingDestinationData $destination = null,
        public ?string $routingReference = null,
        public int $derivationCounter = 0,
        public ?string $existingFundingAddress = null,
        public ?FundingQrMerchantData $qrMerchant = null,
    ) {}
}
