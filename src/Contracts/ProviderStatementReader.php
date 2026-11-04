<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\ProviderStatementRequestData;
use LBHurtado\EmiCore\Data\Providers\ProviderStatementTransactionData;

interface ProviderStatementReader extends SettlementProviderCapability
{
    /** @return iterable<ProviderStatementTransactionData> */
    public function readStatement(ProviderStatementRequestData $request): iterable;
}
