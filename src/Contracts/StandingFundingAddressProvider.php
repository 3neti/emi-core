<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressRequestData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingObservationRequestData;

interface StandingFundingAddressProvider
{
    public function providerCode(): string;

    public function createStandingFundingAddress(
        StandingFundingAddressRequestData $request,
    ): StandingFundingAddressData;

    /**
     * @return list<ProviderFundingObservationData>
     */
    public function observeStandingFundingAddress(
        StandingFundingObservationRequestData $request,
    ): array;
}
