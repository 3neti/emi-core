<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReconciliationEntry extends Model
{
    protected $fillable = [
        'transaction_id',
        'provider_code',
        'request_id',
        'local_status',
        'provider_status',
        'is_match',
        'notes',
        'reconciled_at',
    ];

    protected function casts(): array
    {
        return [
            'is_match' => 'boolean',
            'reconciled_at' => 'datetime',
        ];
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
