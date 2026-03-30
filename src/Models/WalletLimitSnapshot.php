<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletLimitSnapshot extends Model
{
    protected $fillable = [
        'wallet_id',
        'remaining_wallet_limit',
        'remaining_inflow_limit',
        'remaining_annual_inflow_limit',
        'remaining_outflow_limit',
        'captured_at',
        'source_payload',
    ];

    protected function casts(): array
    {
        return [
            'remaining_wallet_limit' => 'decimal:2',
            'remaining_inflow_limit' => 'decimal:2',
            'remaining_annual_inflow_limit' => 'decimal:2',
            'remaining_outflow_limit' => 'decimal:2',
            'captured_at' => 'datetime',
            'source_payload' => 'array',
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
