<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use Spatie\LaravelData\Data;

class ProviderAccountProvisioningResultData extends Data
{
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public string $providerAccountReference,
        public string $status,
        public bool $created,
    ) {}
}
