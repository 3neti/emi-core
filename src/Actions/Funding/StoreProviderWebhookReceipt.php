<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Actions\Funding;

use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use LBHurtado\EmiCore\Data\Funding\ProviderEventHintData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookRequestData;
use LBHurtado\EmiCore\Data\Funding\WebhookAuthenticationData;
use LBHurtado\EmiCore\Exceptions\ProviderEvidenceConflict;
use LBHurtado\EmiCore\Models\WebhookReceipt;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreProviderWebhookReceipt
{
    use AsAction;

    public function handle(
        ProviderWebhookRequestData $request,
        WebhookAuthenticationData $authentication,
        ?ProviderEventHintData $event = null,
    ): WebhookReceipt {
        $provider = $this->normalizeRequiredValue($request->provider, 'provider');
        $bodySha256 = hash('sha256', $request->rawBody);
        $providerEventId = $this->normalizeOptionalValue($event?->providerEventId);
        $deduplicationIdentity = $providerEventId === null
            ? 'body:'.$bodySha256
            : 'event:'.$providerEventId;
        $deduplicationKey = hash('sha256', $provider."\0".$deduplicationIdentity);

        try {
            return DB::transaction(
                fn (): WebhookReceipt => WebhookReceipt::query()->create([
                    'provider_code' => $provider,
                    'deduplication_key' => $deduplicationKey,
                    'event_type' => $this->normalizeOptionalValue($event?->eventType),
                    'request_id' => $this->normalizeOptionalValue($event?->requestId),
                    'postback_id' => $providerEventId,
                    'provider_event_id' => $providerEventId,
                    'signature' => null,
                    'signature_ciphertext' => $request->signature,
                    'signature_verified' => $authentication->authenticated,
                    'payload' => [],
                    'body_sha256' => $bodySha256,
                    'content_type' => $this->normalizeOptionalValue($request->contentType),
                    'raw_body' => $request->rawBody,
                    'headers' => $request->headers,
                    'source_ip' => $this->normalizeOptionalValue($request->sourceIp),
                    'authentication_status' => $authentication->authenticated ? 'authenticated' : 'rejected',
                    'received_at' => $request->receivedAt,
                    'processing_status' => $authentication->authenticated ? 'received' : 'rejected',
                    'error_message' => $authentication->authenticated ? null : $authentication->reason,
                ]),
                3,
            );
        } catch (UniqueConstraintViolationException $exception) {
            $receipt = WebhookReceipt::query()
                ->where('deduplication_key', $deduplicationKey)
                ->first();

            if ($receipt === null) {
                throw $exception;
            }

            if (! hash_equals((string) $receipt->body_sha256, $bodySha256)) {
                throw ProviderEvidenceConflict::changedBody(
                    provider: $provider,
                    providerEventId: $providerEventId ?? $bodySha256,
                );
            }

            return $receipt;
        }
    }

    private function normalizeRequiredValue(string $value, string $field): string
    {
        $normalized = strtolower(trim($value));

        if ($normalized === '') {
            throw new InvalidArgumentException(sprintf('%s is required.', ucfirst($field)));
        }

        return $normalized;
    }

    private function normalizeOptionalValue(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = trim($value);

        return $normalized === '' ? null : $normalized;
    }
}
