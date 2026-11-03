<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingInstructionRequestData;
use LBHurtado\EmiCore\Data\Funding\FundingInstructionsData;

interface OnDemandFundingInstructionProvider
{
    public function createOnDemandFundingInstructions(FundingInstructionRequestData $request, bool $fixedQrEnabled): FundingInstructionsData;
}
