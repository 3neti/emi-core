<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class ProviderEventHintData extends Data
{
    public function __construct(
        public ?string $providerEventId = null,
        public ?string $eventType = null,
        public ?string $requestId = null,
    ) {}
}
