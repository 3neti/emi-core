<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use LBHurtado\EmiCore\Enums\AccountTransferStatus;
use Spatie\LaravelData\Data;

class AccountTransferResultData extends Data
{
    public function __construct(
        public readonly AccountTransferStatus $status,
        public readonly ?string $providerTransactionId = null,
        public readonly ?AccountTransferEvidenceData $evidence = null,
    ) {}
}
