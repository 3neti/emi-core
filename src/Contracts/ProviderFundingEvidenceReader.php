<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Data\Providers\ProviderFundingEvidenceRequestData;

interface ProviderFundingEvidenceReader extends SettlementProviderCapability
{
    /**
     * @return list<ProviderFundingObservationData>
     */
    public function readFundingEvidence(ProviderFundingEvidenceRequestData $request): array;
}
