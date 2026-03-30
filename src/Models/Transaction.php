<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LBHurtado\EmiCore\Enums\ProviderCode;
use LBHurtado\EmiCore\Enums\TransactionDirection;
use LBHurtado\EmiCore\Enums\TransactionStatus;
use LBHurtado\EmiCore\Enums\TransactionType;

class Transaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'source_wallet_id',
        'destination_wallet_id',
        'provider_account_id',
        'provider_code',
        'provider_transaction_id',
        'provider_reference',
        'request_id',
        'transaction_type',
        'direction',
        'status',
        'amount',
        'fee',
        'final_amount',
        'currency',
        'occurred_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'provider_code' => ProviderCode::class,
            'transaction_type' => TransactionType::class,
            'direction' => TransactionDirection::class,
            'status' => TransactionStatus::class,
            'amount' => 'decimal:2',
            'fee' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'occurred_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function sourceWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'source_wallet_id');
    }

    public function destinationWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'destination_wallet_id');
    }
}
