<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

class FundingDestinationData extends Data
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function __construct(
        public string $provider,
        public string $mode,
        public string $destinationType,
        public string $accountReference,
        public string $displayReference,
        public string $fingerprint,
        public string $verificationStatus,
        public ?string $providerAccountId = null,
        public ?string $providerWalletId = null,
        public ?string $bankAccountNumber = null,
        public ?string $bankAccountName = null,
        public ?string $routingAlias = null,
        public ?string $routingCredential = null,
        public array $metadata = [],
    ) {}
}
