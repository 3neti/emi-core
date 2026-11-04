<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use Spatie\LaravelData\Data;

final class ProviderWalletBalanceData extends Data
{
    /**
     * @param  array<string, mixed>  $metadata
     * @param  array<string, mixed>  $response
     */
    public function __construct(
        public float $balance,
        public string $currency,
        public ?string $customerId,
        public array $metadata = [],
        public array $response = [],
    ) {}
}
