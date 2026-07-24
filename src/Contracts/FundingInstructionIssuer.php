<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingInstructionRequestData;
use LBHurtado\EmiCore\Data\Funding\FundingInstructionsData;

interface FundingInstructionIssuer extends SettlementProviderCapability
{
    public function createFundingInstructions(
        FundingInstructionRequestData $request,
    ): FundingInstructionsData;
}
