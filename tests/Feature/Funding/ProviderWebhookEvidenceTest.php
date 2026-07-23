<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use LBHurtado\EmiCore\Actions\Funding\StoreProviderWebhookReceipt;
use LBHurtado\EmiCore\Data\Funding\ProviderEventHintData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookReceiptData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookRequestData;
use LBHurtado\EmiCore\Data\Funding\WebhookAuthenticationData;
use LBHurtado\EmiCore\Exceptions\ImmutableProviderEvidence;
use LBHurtado\EmiCore\Exceptions\ProviderEvidenceConflict;
use LBHurtado\EmiCore\Models\WebhookReceipt;

function webhookRequest(string $body = '{"status":"settled"}'): ProviderWebhookRequestData
{
    return new ProviderWebhookRequestData(
        provider: 'Future_EMI',
        rawBody: $body,
        contentType: 'application/json',
        headers: ['x-provider-signature' => ['signature-value']],
        sourceIp: '203.0.113.10',
        receivedAt: new DateTimeImmutable('2026-07-23T09:00:00+08:00'),
        signature: 'signature-value',
    );
}

function authenticatedWebhook(): WebhookAuthenticationData
{
    return new WebhookAuthenticationData(
        authenticated: true,
        method: 'hmac-sha256',
    );
}

function webhookEvent(): ProviderEventHintData
{
    return new ProviderEventHintData(
        providerEventId: 'event-1001',
        eventType: 'cash_in.settled',
        requestId: 'intent-1001',
    );
}

it('stores pristine webhook evidence encrypted at rest and deduplicates provider retries', function () {
    $store = app(StoreProviderWebhookReceipt::class);

    $first = $store->handle(webhookRequest(), authenticatedWebhook(), webhookEvent());
    $retry = $store->handle(webhookRequest(), authenticatedWebhook(), webhookEvent());

    expect($retry->getKey())->toBe($first->getKey())
        ->and(WebhookReceipt::query()->count())->toBe(1)
        ->and($first->provider_code)->toBe('future_emi')
        ->and($first->raw_body)->toBe('{"status":"settled"}')
        ->and($first->headers)->toBe(['x-provider-signature' => ['signature-value']])
        ->and($first->body_sha256)->toBe(hash('sha256', '{"status":"settled"}'))
        ->and($first->authentication_status)->toBe('authenticated')
        ->and($first->signature_verified)->toBeTrue();

    $stored = DB::table('webhook_receipts')->where('id', $first->getKey())->first();

    expect($stored->raw_body)->not->toContain('settled')
        ->and($stored->headers)->not->toContain('signature-value')
        ->and($stored->signature)->toBeNull()
        ->and($stored->signature_ciphertext)->not->toBe('signature-value')
        ->and($first->toArray())->not->toHaveKeys(['signature', 'payload', 'raw_body', 'headers']);
});

it('rejects a reused provider event identifier with a changed body', function () {
    $store = app(StoreProviderWebhookReceipt::class);

    $store->handle(webhookRequest(), authenticatedWebhook(), webhookEvent());

    expect(fn () => $store->handle(
        webhookRequest('{"status":"reversed"}'),
        authenticatedWebhook(),
        webhookEvent(),
    ))->toThrow(ProviderEvidenceConflict::class);
});

it('keeps receipt evidence immutable while allowing processing state transitions', function () {
    $receipt = app(StoreProviderWebhookReceipt::class)
        ->handle(webhookRequest(), authenticatedWebhook(), webhookEvent());

    $receipt->update([
        'processing_status' => 'verified',
        'processed_at' => now(),
    ]);

    expect($receipt->refresh()->processing_status)->toBe('verified');

    expect(fn () => $receipt->update(['raw_body' => '{"tampered":true}']))
        ->toThrow(ImmutableProviderEvidence::class);

    $receipt->refresh();

    expect(fn () => $receipt->update(['authentication_status' => 'rejected']))
        ->toThrow(ImmutableProviderEvidence::class);
});

it('reconstructs the provider adapter receipt without losing raw bytes', function () {
    $receipt = app(StoreProviderWebhookReceipt::class)
        ->handle(webhookRequest(), authenticatedWebhook(), webhookEvent());

    $data = ProviderWebhookReceiptData::fromModel($receipt);

    expect($data->receiptId)->toBe($receipt->getKey())
        ->and($data->rawBody)->toBe('{"status":"settled"}')
        ->and($data->bodySha256)->toBe(hash('sha256', '{"status":"settled"}'))
        ->and($data->authentication->authenticated)->toBeTrue();
});
