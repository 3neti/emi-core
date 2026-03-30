<?php

use LBHurtado\EmiCore\Contracts\PayoutProvider;

it('declares the expected interface methods', function () {
    $reflection = new ReflectionClass(PayoutProvider::class);

    expect($reflection->isInterface())->toBeTrue();
    expect($reflection->hasMethod('disburse'))->toBeTrue();
    expect($reflection->hasMethod('checkStatus'))->toBeTrue();
    expect($reflection->hasMethod('getRailFee'))->toBeTrue();
});
