<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data;

use Spatie\LaravelData\Data;

class PayoutPartyData extends Data
{
    public function __construct(
        public string $role,
        public ?string $name = null,
        public ?PayoutAddressData $address = null,
    ) {}
}
