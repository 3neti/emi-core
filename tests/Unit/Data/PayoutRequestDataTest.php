<?php

use LBHurtado\EmiCore\Data\PayoutRequestData;
use LBHurtado\EmiCore\Enums\SettlementRail;

it('can be constructed with required fields', function () {
    $data = PayoutRequestData::from([
        'reference' => 'VOUCHER-001-09171234567',
        'amount' => 100.50,
        'account_number' => '09171234567',
        'bank_code' => 'GXCHPHM2XXX',
        'settlement_rail' => 'INSTAPAY',
    ]);

    expect($data->reference)->toBe('VOUCHER-001-09171234567');
    expect($data->amount)->toBe(100.50);
    expect($data->account_number)->toBe('09171234567');
    expect($data->bank_code)->toBe('GXCHPHM2XXX');
    expect($data->settlement_rail)->toBe('INSTAPAY');
    expect($data->currency)->toBe('PHP');
});

it('sanitizes account number by stripping non-numeric characters', function () {
    $data = PayoutRequestData::from([
        'reference' => 'REF-001',
        'amount' => 50,
        'account_number' => '0 917-301 1987',
        'bank_code' => 'GXCHPHM2XXX',
        'settlement_rail' => 'INSTAPAY',
    ]);

    expect($data->account_number)->toBe('09173011987');
});

it('can resolve SettlementRail enum', function () {
    $data = PayoutRequestData::from([
        'reference' => 'REF-001',
        'amount' => 50,
        'account_number' => '09171234567',
        'bank_code' => 'GXCHPHM2XXX',
        'settlement_rail' => 'PESONET',
    ]);

    expect($data->getSettlementRail())->toBe(SettlementRail::PESONET);
});

it('serializes to array', function () {
    $data = PayoutRequestData::from([
        'reference' => 'REF-001',
        'amount' => 50,
        'account_number' => '09171234567',
        'bank_code' => 'GXCHPHM2XXX',
        'settlement_rail' => 'INSTAPAY',
    ]);

    $array = $data->toArray();
    expect($array)->toHaveKeys(['reference', 'amount', 'account_number', 'bank_code', 'settlement_rail']);
});
