<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingInstructionRequestData;
use LBHurtado\EmiCore\Data\Funding\FundingInstructionsData;

/** Optional capability for QR instructions without registering a funding address. */
interface DirectQrFundingInstructionIssuer extends SettlementProviderCapability
{
    public function createDirectQrFundingInstructions(
        FundingInstructionRequestData $request,
    ): FundingInstructionsData;
}
