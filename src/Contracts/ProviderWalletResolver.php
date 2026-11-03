<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderWalletResolver
{
    public function resolve(): object;
}
