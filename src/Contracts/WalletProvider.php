<?php

namespace LBHurtado\EmiCore\Contracts;

use Spatie\LaravelData\Data;

interface WalletProvider
{
    public function addMerchantWallet(Data $data): Data;

    public function addCustomerWallet(Data $data): Data;

    public function getWalletDetails(string $walletId): Data;

    public function getWalletBalance(string $walletId): Data;

    public function editWallet(string $walletId, Data $data): Data;
}
