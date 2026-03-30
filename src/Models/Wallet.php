<?php

namespace LBHurtado\EmiCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use LBHurtado\EmiCore\Enums\ComplianceLevel;
use LBHurtado\EmiCore\Enums\ProviderCode;
use LBHurtado\EmiCore\Enums\VerificationStatus;
use LBHurtado\EmiCore\Enums\WalletStatus;
use LBHurtado\EmiCore\Enums\WalletType;

class Wallet extends Model
{
    protected $fillable = [
        'provider_account_id',
        'provider_code',
        'provider_wallet_id',
        'provider_account_id_value',
        'account_no',
        'external_uid',
        'wallet_type',
        'status',
        'compliance_level',
        'verification_status',
        'balance_cached',
        'currency',
        'notification_url',
        'capture_link',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'provider_code' => ProviderCode::class,
            'wallet_type' => WalletType::class,
            'status' => WalletStatus::class,
            'compliance_level' => ComplianceLevel::class,
            'verification_status' => VerificationStatus::class,
            'balance_cached' => 'decimal:2',
            'meta' => 'array',
        ];
    }

    public function providerAccount(): BelongsTo
    {
        return $this->belongsTo(ProviderAccount::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(WalletProfile::class);
    }

    public function limitSnapshots(): HasMany
    {
        return $this->hasMany(WalletLimitSnapshot::class);
    }
}
