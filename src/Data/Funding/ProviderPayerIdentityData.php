<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class ProviderPayerIdentityData extends Data
{
    public function __construct(
        public ?string $mobile = null,
        public string $verificationSource = 'provider-observation',
        public bool $providerVerified = false,
    ) {}
}
