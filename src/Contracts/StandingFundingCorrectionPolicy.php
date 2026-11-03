<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Models\ProviderFundingObservation;

interface StandingFundingCorrectionPolicy
{
    public function correctionVersion(ProviderFundingObservation $original, ProviderFundingObservation $corrected): ?string;
}
