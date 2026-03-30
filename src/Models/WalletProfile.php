<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletProfile extends Model
{
    protected $fillable = [
        'wallet_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'mobile_no',
        'address',
        'city',
        'zip',
        'state',
        'country',
        'nationality',
        'source_of_funds',
        'birthdate',
        'company_name',
        'tin',
        'website',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'meta' => 'array',
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
