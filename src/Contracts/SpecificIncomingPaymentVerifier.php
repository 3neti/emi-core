<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingVerificationData;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;

/** Optional capability for authoritative verification of one observed provider transaction. */
interface SpecificIncomingPaymentVerifier extends SettlementProviderCapability
{
    public function verifyIncomingPayment(FundingVerificationData $verification, string $providerTransactionId): ProviderFundingObservationData;
}
