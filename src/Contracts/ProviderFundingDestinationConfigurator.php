<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\ProviderFundingDestinationConfigurationData;

interface ProviderFundingDestinationConfigurator
{
    /** @param array<string, mixed> $input */
    public function configureFundingDestination(array $input): ProviderFundingDestinationConfigurationData;
}
