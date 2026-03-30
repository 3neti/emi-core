<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use LBHurtado\EmiCore\Enums\ProviderCode;

class ProviderAccount extends Model
{
    protected $fillable = [
        'provider_code',
        'name',
        'merchant_id',
        'integration_key',
        'base_url',
        'is_active',
        'config',
    ];

    protected function casts(): array
    {
        return [
            'provider_code' => ProviderCode::class,
            'is_active' => 'boolean',
            'config' => 'array',
        ];
    }
}
