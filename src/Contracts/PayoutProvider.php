<?php

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\PayoutRequestData;
use LBHurtado\EmiCore\Data\PayoutResultData;
use LBHurtado\EmiCore\Enums\SettlementRail;

interface PayoutProvider
{
    /**
     * Disburse funds to a recipient.
     */
    public function disburse(PayoutRequestData $request): PayoutResultData;

    /**
     * Check the status of a payout transaction.
     */
    public function checkStatus(string $transactionId): PayoutResultData;

    /**
     * Get the fee for a specific settlement rail in minor units (centavos).
     */
    public function getRailFee(SettlementRail $rail): int;
}
