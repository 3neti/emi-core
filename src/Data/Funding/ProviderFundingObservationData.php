<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use DateTimeImmutable;
use Spatie\LaravelData\Data;

class ProviderFundingObservationData extends Data
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function __construct(
        public string $provider,
        public string $providerTransactionId,
        public int $grossAmountMinor,
        public int $feeAmountMinor,
        public int $netAmountMinor,
        public string $currency,
        public string $providerStatus,
        public string $verificationSource,
        public string $payloadHash,
        public ?string $providerOperationId = null,
        public ?string $requestId = null,
        public ?string $fundingAddress = null,
        public ?string $providerAccountReference = null,
        public ?DateTimeImmutable $occurredAt = null,
        public ?DateTimeImmutable $settledAt = null,
        public ?int $webhookReceiptId = null,
        public array $metadata = [],
    ) {}
}
