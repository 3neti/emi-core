<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data;

use Spatie\LaravelData\Data;

class PayoutIdentityRequirementsData extends Data
{
    /** @param list<string> $required_address_fields */
    public function __construct(
        public array $required_address_fields,
        public ?int $address1_max_length = null,
    ) {}
}
