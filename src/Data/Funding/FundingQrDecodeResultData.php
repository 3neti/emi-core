<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

final class FundingQrDecodeResultData extends Data
{
    /**
     * @param  array<string, mixed>  $providerData
     */
    public function __construct(
        public string $qrString,
        public array $providerData = [],
    ) {}
}
