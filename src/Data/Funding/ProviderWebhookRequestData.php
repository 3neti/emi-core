<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class ProviderWebhookRequestData extends Data
{
    /**
     * @param  array<string, string|array<int, string>>  $headers
     */
    public function __construct(
        public string $provider,
        public string $rawBody,
        public ?string $contentType,
        public array $headers,
        public ?string $sourceIp,
        public DateTimeImmutable $receivedAt,
        public ?string $signature = null,
    ) {}
}
