<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Providers\AccountTransferRequestData;
use LBHurtado\EmiCore\Data\Providers\AccountTransferResultData;

interface AccountTransferProvider
{
    public function providerCode(): string;

    public function submit(AccountTransferRequestData $request): AccountTransferResultData;

    public function checkStatus(string $providerTransactionId): AccountTransferResultData;
}
