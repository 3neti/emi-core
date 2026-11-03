<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class StandingFundingAddressProfileData extends Data
{
    public function __construct(
        public bool $configured,
        public bool $ready,
        public string $status,
        public ?string $scheme,
        public string $schemeLabel,
        public ?string $schemeWarning,
        public bool $productionSafe,
        public bool $requiresVerifiedMobile,
        public ?string $routingReference,
    ) {}
}
