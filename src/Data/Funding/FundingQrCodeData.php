<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class FundingQrCodeData extends Data
{
    public function __construct(
        public string $mimeType,
        public string $base64Payload,
        public string $qrMode,
        public string $transactionType,
        public bool $embeddedAmount,
        public bool $providerGenerated,
    ) {}
}
