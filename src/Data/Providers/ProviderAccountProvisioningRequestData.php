<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use Spatie\LaravelData\Data;

class ProviderAccountProvisioningRequestData extends Data
{
    /**
     * @param  array<string, scalar|null>  $attributes
     */
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public string $principalReference,
        public string $idempotencyKey,
        public array $attributes = [],
    ) {}
}
