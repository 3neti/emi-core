<?php

namespace LBHurtado\EmiCore\Data;

use LBHurtado\EmiCore\Enums\SettlementRail;
use Spatie\LaravelData\Data;

class PayoutRequestData extends Data
{
    public function __construct(
        public string $reference,
        public int|float $amount,
        public string $account_number,
        public string $bank_code,
        public string $settlement_rail,
        public string $currency = 'PHP',
        public ?string $external_id = null,
        public ?string $external_code = null,
        public ?int $user_id = null,
        public ?string $mobile = null,
        public ?array $metadata = null,
    ) {
        // Sanitize account number: strip all non-numeric characters
        $this->account_number = preg_replace('/[^0-9]/', '', $account_number);
    }

    public function getSettlementRail(): SettlementRail
    {
        return SettlementRail::from($this->settlement_rail);
    }
}
