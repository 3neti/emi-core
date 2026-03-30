<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    protected $fillable = [
        'transaction_id',
        'pre_transfer_reference',
        'settled_at',
        'cancelled_at',
        'is_phantom_destination',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'settled_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'is_phantom_destination' => 'boolean',
            'meta' => 'array',
        ];
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
