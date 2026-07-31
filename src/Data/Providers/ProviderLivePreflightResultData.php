<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use DateTimeImmutable;
use LBHurtado\EmiCore\Enums\ProviderLivePreflightFailureCode;
use Spatie\LaravelData\Data;

class ProviderLivePreflightResultData extends Data
{
    public function __construct(
        public string $provider,
        public string $connectionReference,
        public bool $ready,
        public DateTimeImmutable $checkedAt,
        public ?ProviderBalanceObservationData $observation = null,
        public ?ProviderLivePreflightFailureCode $failureCode = null,
    ) {}
}
