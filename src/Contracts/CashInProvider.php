<?php

namespace LBHurtado\EmiCore\Contracts;

use Spatie\LaravelData\Data;

interface CashInProvider
{
    public function createCashIn(Data $data): Data;

    public function getCashInByRequestId(string $requestId): Data;
}
