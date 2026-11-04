<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

final class ProviderFundingDestinationConfigurationData extends Data
{
    /**
     * @param  list<string>  $capabilities
     * @param  array<string, mixed>  $metadata
     * @param  array<string, mixed>  $routingProfile
     */
    public function __construct(
        public string $mode,
        public string $verificationStatus,
        public string $identityLevel,
        public array $capabilities,
        public array $metadata,
        public array $routingProfile,
        public string $fingerprint,
        public string $displayReference,
    ) {}
}
