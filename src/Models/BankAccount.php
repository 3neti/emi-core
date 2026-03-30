<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    protected $fillable = [
        'wallet_id',
        'provider_bank_account_id',
        'bank_code',
        'bank_name',
        'account_name',
        'account_number_masked',
        'status',
        'is_registered',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'is_registered' => 'boolean',
            'meta' => 'array',
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
