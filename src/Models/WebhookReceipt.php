<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use LBHurtado\EmiCore\Enums\ProviderCode;

class WebhookReceipt extends Model
{
    protected $fillable = [
        'provider_code',
        'event_type',
        'request_id',
        'postback_id',
        'signature',
        'signature_verified',
        'payload',
        'processing_status',
        'processed_at',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'provider_code' => ProviderCode::class,
            'signature_verified' => 'boolean',
            'payload' => 'array',
            'processed_at' => 'datetime',
        ];
    }
}
