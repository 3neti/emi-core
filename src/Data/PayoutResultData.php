<?php

namespace LBHurtado\EmiCore\Data;

use LBHurtado\EmiCore\Enums\PayoutStatus;
use Spatie\LaravelData\Data;

class PayoutResultData extends Data
{
    public function __construct(
        public string $transaction_id,
        public string $uuid,
        public PayoutStatus $status,
        public ?string $provider = null,
        public ?array $metadata = null,
    ) {}
}
