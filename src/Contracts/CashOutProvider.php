<?php

namespace LBHurtado\EmiCore\Contracts;

use Spatie\LaravelData\Data;

interface CashOutProvider
{
    public function createCashOut(Data $data): Data;

    public function createCashOutOtp(Data $data): Data;

    public function verifyTransaction(Data $data): Data;
}
