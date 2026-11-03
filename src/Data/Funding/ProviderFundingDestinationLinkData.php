<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use Spatie\LaravelData\Data;

final class ProviderFundingDestinationLinkData extends Data
{
    /** @param array<string, mixed>|null $routing */
    public function __construct(
        public string $verificationStatus,
        public ?string $providerAccountId,
        public ?string $providerWalletId,
        public ?string $displayReference,
        public ?string $fingerprint,
        public ?array $routing,
    ) {}
}
