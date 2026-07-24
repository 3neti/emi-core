<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use DateTimeImmutable;
use LBHurtado\EmiCore\Enums\ProviderCapability;
use Spatie\LaravelData\Data;

class ProviderCapabilityReadinessData extends Data
{
    /**
     * @param  array<string, bool>  $checks
     * @param  array<string, list<string>>  $issues
     */
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public array $checks,
        public array $issues,
        public DateTimeImmutable $checkedAt,
    ) {}

    /**
     * @param  list<ProviderCapability>  $capabilities
     */
    public function readyFor(array $capabilities): bool
    {
        foreach ($capabilities as $capability) {
            if (($this->checks[$capability->value] ?? false) !== true) {
                return false;
            }
        }

        return true;
    }
}
