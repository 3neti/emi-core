<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Actions\Funding;

use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Models\ProviderFundingObservation;
use Lorisleiva\Actions\Concerns\AsAction;

class RecordProviderFundingObservation
{
    use AsAction;

    public function handle(ProviderFundingObservationData $observation): ProviderFundingObservation
    {
        $provider = $this->requiredLowercase($observation->provider, 'Provider');
        $providerTransactionId = $this->required($observation->providerTransactionId, 'Provider transaction ID');
        $providerStatus = $this->requiredLowercase($observation->providerStatus, 'Provider status');
        $verificationSource = $this->requiredLowercase($observation->verificationSource, 'Verification source');
        $currency = strtoupper($this->required($observation->currency, 'Currency'));
        $payloadHash = strtolower($this->required($observation->payloadHash, 'Payload hash'));
        $normalizationVersion = $this->normalizationVersion($observation->metadata);

        if (strlen($currency) !== 3) {
            throw new InvalidArgumentException('Currency must be a three-letter code.');
        }

        if (preg_match('/\A[a-f0-9]{64}\z/', $payloadHash) !== 1) {
            throw new InvalidArgumentException('Payload hash must be a lowercase SHA-256 digest.');
        }

        if ($observation->grossAmountMinor <= 0) {
            throw new InvalidArgumentException('Gross amount must be greater than zero.');
        }

        if ($observation->feeAmountMinor < 0 || $observation->netAmountMinor < 0) {
            throw new InvalidArgumentException('Fee and net amounts cannot be negative.');
        }

        if ($observation->feeAmountMinor > $observation->grossAmountMinor
            || $observation->netAmountMinor > $observation->grossAmountMinor) {
            throw new InvalidArgumentException('Fee and net amounts cannot exceed the gross amount.');
        }

        $observationKey = hash('sha256', implode("\0", [
            $provider,
            $providerTransactionId,
            $providerStatus,
            $payloadHash,
            $normalizationVersion,
        ]));

        try {
            return DB::transaction(
                fn (): ProviderFundingObservation => ProviderFundingObservation::query()->create([
                    'observation_key' => $observationKey,
                    'provider_code' => $provider,
                    'provider_transaction_id' => $providerTransactionId,
                    'provider_operation_id' => $this->optional($observation->providerOperationId),
                    'request_id' => $this->optional($observation->requestId),
                    'funding_address' => $this->optional($observation->fundingAddress),
                    'provider_account_reference' => $this->optional($observation->providerAccountReference),
                    'gross_amount_minor' => $observation->grossAmountMinor,
                    'fee_amount_minor' => $observation->feeAmountMinor,
                    'net_amount_minor' => $observation->netAmountMinor,
                    'currency' => $currency,
                    'provider_status' => $providerStatus,
                    'occurred_at' => $observation->occurredAt,
                    'settled_at' => $observation->settledAt,
                    'verification_source' => $verificationSource,
                    'webhook_receipt_id' => $observation->webhookReceiptId,
                    'payload_hash' => $payloadHash,
                    'metadata' => $observation->metadata,
                ]),
                3,
            );
        } catch (UniqueConstraintViolationException $exception) {
            $recorded = ProviderFundingObservation::query()
                ->where('observation_key', $observationKey)
                ->first();

            if ($recorded === null) {
                throw $exception;
            }

            return $recorded;
        }
    }

    private function required(string $value, string $field): string
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw new InvalidArgumentException($field.' is required.');
        }

        return $normalized;
    }

    private function requiredLowercase(string $value, string $field): string
    {
        return strtolower($this->required($value, $field));
    }

    private function optional(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = trim($value);

        return $normalized === '' ? null : $normalized;
    }

    /**
     * @param  array<string, mixed>  $metadata
     */
    private function normalizationVersion(array $metadata): string
    {
        $version = data_get($metadata, 'normalization_version');

        if ($version === null) {
            return '';
        }

        if (! is_string($version)
            || preg_match('/\A[a-z0-9][a-z0-9._-]{0,63}\z/', $version) !== 1) {
            throw new InvalidArgumentException(
                'Normalization version must be a safe lowercase identifier.',
            );
        }

        return $version;
    }
}
