<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

final class FundingQrDisplayContentData extends Data
{
    public function __construct(
        public FundingQrDisplayContentFormat $format,
        public string $value,
        public bool $providerGenerated = true,
    ) {}
}
