<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class WebhookAuthenticationData extends Data
{
    public function __construct(
        public bool $authenticated,
        public string $method,
        public ?string $reason = null,
    ) {}
}
