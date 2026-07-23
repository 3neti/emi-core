<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use LBHurtado\EmiCore\Enums\FundingAddressPurpose;
use Spatie\LaravelData\Data;

class StandingFundingAddressData extends Data
{
    /**
     * @param  array<string, mixed>  $displayData
     */
    public function __construct(
        public string $provider,
        public string $providerReference,
        public string $fundingAddress,
        public string $accountReference,
        public FundingAddressPurpose $purpose,
        public string $currency,
        public FundingQrCodeData $qrCode,
        public bool $reusable = true,
        public array $displayData = [],
    ) {}
}
