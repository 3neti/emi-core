<?php

namespace LBHurtado\EmiCore\Contracts;

use Spatie\LaravelData\Data;

interface TransferProvider
{
    public function preTransfer(Data $data): Data;

    public function settleTransfer(Data $data): Data;

    public function cancelTransfer(Data $data): Data;
}
