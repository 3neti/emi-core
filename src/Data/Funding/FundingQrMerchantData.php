<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class FundingQrMerchantData extends Data
{
    public function __construct(
        public string $displayName,
        public string $city,
        public ?string $categoryCode = null,
        public ?string $profileReference = null,
        public ?string $profileFingerprint = null,
        public string $metadataVersion = 'funding-qr-merchant-v1',
    ) {}
}
