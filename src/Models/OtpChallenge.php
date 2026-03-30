<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtpChallenge extends Model
{
    protected $fillable = [
        'cash_out_id',
        'status',
        'last_sent_at',
        'verified_at',
        'attempt_count',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'last_sent_at' => 'datetime',
            'verified_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function cashOut(): BelongsTo
    {
        return $this->belongsTo(CashOut::class);
    }
}
