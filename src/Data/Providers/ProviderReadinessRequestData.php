<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use LBHurtado\EmiCore\Enums\ProviderCapability;
use Spatie\LaravelData\Data;

class ProviderReadinessRequestData extends Data
{
    /**
     * @param  list<ProviderCapability>  $requiredCapabilities
     */
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public array $requiredCapabilities,
    ) {}
}
