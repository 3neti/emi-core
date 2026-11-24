<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use InvalidArgumentException;
use Spatie\LaravelData\Data;

class AccountTransferRequestData extends Data
{
    public function __construct(
        public readonly string $provider,
        public readonly string $reference,
        public readonly string $idempotencyKey,
        public readonly string $sourceAccountNumber,
        public readonly string $sourceCustomerId,
        public readonly string $destinationAccountNumber,
        public readonly int $amountMinor,
        public readonly string $currency,
        public readonly string $sourceName,
        public readonly string $destinationName,
        public readonly string $destinationBankCode,
    ) {
        foreach ([$provider, $reference, $idempotencyKey, $sourceAccountNumber, $sourceCustomerId, $destinationAccountNumber, $sourceName, $destinationName, $destinationBankCode] as $value) {
            if (trim($value) === '') {
                throw new InvalidArgumentException('Account transfer details are incomplete.');
            }
        }
        if ($amountMinor <= 0 || preg_match('/\A[A-Z]{3}\z/', $currency) !== 1 || strlen($reference) > 36) {
            throw new InvalidArgumentException('The account transfer amount, currency or reference is invalid.');
        }
        $source = preg_replace('/\D+/', '', $sourceAccountNumber);
        $destination = preg_replace('/\D+/', '', $destinationAccountNumber);
        if ($source === '' || $destination === '' || $source === $destination) {
            throw new InvalidArgumentException('The account transfer source and destination must be distinct.');
        }
    }
}
