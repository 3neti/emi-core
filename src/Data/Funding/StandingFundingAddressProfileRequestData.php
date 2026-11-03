<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class StandingFundingAddressProfileRequestData extends Data
{
    public function __construct(
        public ?string $mobile,
        public bool $mobileVerified,
        public ?string $existingFundingAddress = null,
        public ?string $existingScheme = null,
        public bool $validateReadiness = true,
    ) {}
}
