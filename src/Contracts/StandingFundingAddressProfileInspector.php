<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressProfileData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressProfileRequestData;

interface StandingFundingAddressProfileInspector extends SettlementProviderCapability
{
    public function inspectStandingFundingAddressProfile(StandingFundingAddressProfileRequestData $request): StandingFundingAddressProfileData;
}
