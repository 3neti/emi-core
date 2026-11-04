<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingVerificationData;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingHistoryRequestData;

interface ProviderFundingHistoryRequestFactory
{
    public function createFundingHistoryRequest(ProviderFundingHistoryRequestData $request): ?FundingVerificationData;
}
