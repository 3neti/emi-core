<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use Throwable;

interface ProviderFundingRequestFailure extends Throwable
{
    public function operation(): string;
}
