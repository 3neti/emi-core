<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LBHurtado\EmiCore\Exceptions\ImmutableProviderEvidence;

class ProviderFundingObservation extends Model
{
    protected $fillable = [
        'observation_key',
        'provider_code',
        'provider_transaction_id',
        'provider_operation_id',
        'request_id',
        'funding_address',
        'provider_account_reference',
        'gross_amount_minor',
        'fee_amount_minor',
        'net_amount_minor',
        'currency',
        'provider_status',
        'occurred_at',
        'settled_at',
        'verification_source',
        'webhook_receipt_id',
        'payload_hash',
        'metadata',
    ];

    protected static function booted(): void
    {
        static::updating(function (): never {
            throw ImmutableProviderEvidence::observation();
        });

        static::deleting(function (): never {
            throw ImmutableProviderEvidence::observation();
        });
    }

    protected function casts(): array
    {
        return [
            'gross_amount_minor' => 'integer',
            'fee_amount_minor' => 'integer',
            'net_amount_minor' => 'integer',
            'occurred_at' => 'immutable_datetime',
            'settled_at' => 'immutable_datetime',
            'metadata' => 'array',
        ];
    }

    public function webhookReceipt(): BelongsTo
    {
        return $this->belongsTo(WebhookReceipt::class);
    }
}
