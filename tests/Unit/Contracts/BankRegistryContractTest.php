<?php

use LBHurtado\EmiCore\Contracts\BankRegistryContract;
use LBHurtado\EmiCore\Support\NullBankRegistry;

it('can resolve the bank registry contract from the container', function () {
    $registry = app(BankRegistryContract::class);

    expect($registry)->toBeInstanceOf(BankRegistryContract::class)
        ->and($registry)->toBeInstanceOf(NullBankRegistry::class);
});

it('provides a safe null bank registry fallback', function () {
    $registry = new NullBankRegistry();

    expect($registry->isEMI('GCASH'))->toBeFalse()
        ->and($registry->getBankName('GCASH'))->toBe('GCASH')
        ->and($registry->getBankLogo('GCASH'))->toBeNull();
});