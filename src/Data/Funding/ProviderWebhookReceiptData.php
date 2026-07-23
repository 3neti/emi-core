<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

use DateTimeImmutable;
use LBHurtado\EmiCore\Models\WebhookReceipt;
use Spatie\LaravelData\Data;

class ProviderWebhookReceiptData extends Data
{
    /**
     * @param  array<string, string|array<int, string>>  $headers
     */
    public function __construct(
        public ?int $receiptId,
        public string $provider,
        public string $rawBody,
        public ?string $contentType,
        public array $headers,
        public ?string $sourceIp,
        public DateTimeImmutable $receivedAt,
        public string $bodySha256,
        public WebhookAuthenticationData $authentication,
        public ?string $signature = null,
    ) {}

    public static function fromRequest(
        ProviderWebhookRequestData $request,
        WebhookAuthenticationData $authentication,
    ): self {
        return new self(
            receiptId: null,
            provider: $request->provider,
            rawBody: $request->rawBody,
            contentType: $request->contentType,
            headers: $request->headers,
            sourceIp: $request->sourceIp,
            receivedAt: $request->receivedAt,
            bodySha256: hash('sha256', $request->rawBody),
            authentication: $authentication,
            signature: $request->signature,
        );
    }

    public static function fromModel(WebhookReceipt $receipt): self
    {
        if ($receipt->received_at === null) {
            throw new \InvalidArgumentException('The webhook receipt does not have a received timestamp.');
        }

        return new self(
            receiptId: $receipt->getKey(),
            provider: (string) $receipt->provider_code,
            rawBody: (string) $receipt->raw_body,
            contentType: $receipt->content_type,
            headers: $receipt->headers ?? [],
            sourceIp: $receipt->source_ip,
            receivedAt: DateTimeImmutable::createFromInterface($receipt->received_at),
            bodySha256: (string) $receipt->body_sha256,
            authentication: new WebhookAuthenticationData(
                authenticated: (bool) $receipt->signature_verified,
                method: 'persisted-receipt',
                reason: $receipt->error_message,
            ),
            signature: $receipt->signature_ciphertext ?? $receipt->signature,
        );
    }
}
