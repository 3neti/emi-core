<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use DateTimeImmutable;

/** An observed incoming payment; payer details are not verified contact details. */
readonly class IncomingPaymentData
{
    public function __construct(
        public string $transactionId,
        public int $amountMinor,
        public string $currency,
        public string $status,
        public ?DateTimeImmutable $occurredAt,
        public ?DateTimeImmutable $settledAt,
        public ?string $referenceId,
        public ?string $settlementRail,
        public ?string $payerName,
        public ?string $payerAccountNumber,
        public ?string $payerInstitutionCode,
        public ?string $payerMobile,
    ) {}
}
