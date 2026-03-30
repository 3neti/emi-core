<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashIn extends Model
{
    protected $fillable = [
        'transaction_id',
        'pmethod',
        'pchannel',
        'payment_action_info',
        'expiry_date',
        'payment_date',
        'sender_details',
        'originating_flow',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'payment_action_info' => 'array',
            'sender_details' => 'array',
            'expiry_date' => 'datetime',
            'payment_date' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
