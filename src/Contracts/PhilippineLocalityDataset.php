<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\PayoutAddressData;

interface PhilippineLocalityDataset
{
    public function version(): string;

    /** @return list<PayoutAddressData> */
    public function candidates(?string $city = null, ?string $region = null): array;
}
