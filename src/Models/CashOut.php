<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CashOut extends Model
{
    protected $fillable = [
        'transaction_id',
        'bank_account_id',
        'otp_status',
        'verified_at',
        'cashout_mode',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function otpChallenge(): HasOne
    {
        return $this->hasOne(OtpChallenge::class);
    }
}
