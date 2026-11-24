<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data;

use Spatie\LaravelData\Data;

class PayoutSourceAccountData extends Data
{
    public function __construct(
        public string $provider,
        public string $account_number,
        public string $customer_id,
    ) {}
}
