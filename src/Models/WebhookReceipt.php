<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LBHurtado\EmiCore\Exceptions\ImmutableProviderEvidence;

class WebhookReceipt extends Model
{
    protected $fillable = [
        'provider_code',
        'deduplication_key',
        'event_type',
        'request_id',
        'postback_id',
        'provider_event_id',
        'signature',
        'signature_ciphertext',
        'signature_verified',
        'payload',
        'body_sha256',
        'content_type',
        'raw_body',
        'headers',
        'source_ip',
        'authentication_status',
        'received_at',
        'processing_status',
        'processed_at',
        'error_message',
    ];

    protected $hidden = [
        'signature',
        'signature_ciphertext',
        'payload',
        'raw_body',
        'headers',
    ];

    protected static function booted(): void
    {
        static::updating(function (self $receipt): void {
            $evidenceAttributes = [
                'provider_code',
                'deduplication_key',
                'event_type',
                'request_id',
                'postback_id',
                'provider_event_id',
                'signature',
                'signature_ciphertext',
                'signature_verified',
                'payload',
                'body_sha256',
                'content_type',
                'raw_body',
                'headers',
                'source_ip',
                'authentication_status',
                'received_at',
            ];

            if ($receipt->isDirty($evidenceAttributes)) {
                throw ImmutableProviderEvidence::receipt();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'signature_ciphertext' => 'encrypted',
            'signature_verified' => 'boolean',
            'payload' => 'array',
            'raw_body' => 'encrypted',
            'headers' => 'encrypted:array',
            'received_at' => 'immutable_datetime',
            'processed_at' => 'datetime',
        ];
    }

    public function fundingObservations(): HasMany
    {
        return $this->hasMany(ProviderFundingObservation::class);
    }
}
