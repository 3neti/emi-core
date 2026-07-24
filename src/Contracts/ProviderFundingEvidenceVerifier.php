<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingVerificationData;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;

interface ProviderFundingEvidenceVerifier extends SettlementProviderCapability
{
    public function verifyFunding(
        FundingVerificationData $verification,
    ): ProviderFundingObservationData;
}
