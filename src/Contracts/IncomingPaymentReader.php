<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingVerificationData;
use LBHurtado\EmiCore\Data\Funding\IncomingPaymentData;

/** Optional, observation-only capability; results do not confirm collection. */
interface IncomingPaymentReader extends SettlementProviderCapability
{
    /** @return list<IncomingPaymentData> */
    public function incomingPayments(FundingVerificationData $verification): array;
}
