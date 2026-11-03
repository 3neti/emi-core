<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use Spatie\LaravelData\Data;

class ProviderSourceAccountReadinessRequestData extends Data
{
    public function __construct(
        public ?int $requiredAmountMinor = null,
        public bool $provisioning = false,
    ) {}
}
