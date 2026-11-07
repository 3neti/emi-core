<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data;

use Spatie\LaravelData\Data;

class PayoutAddressData extends Data
{
    public function __construct(
        public string $address1,
        public string $city,
        public string $country,
        public string $postal_code,
        public string $source,
        public ?string $dataset_version = null,
    ) {}
}
