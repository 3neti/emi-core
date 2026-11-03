<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingDestinationData;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingDestinationLinkData;

interface ProviderFundingDestinationResolver extends SettlementProviderCapability
{
    public function sharedFundingDestination(string $accountReference): FundingDestinationData;

    public function dedicatedFundingDestination(ProviderFundingDestinationLinkData $link, string $accountReference): FundingDestinationData;
}
