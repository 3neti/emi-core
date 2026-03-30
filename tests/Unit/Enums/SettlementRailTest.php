<?php

use LBHurtado\EmiCore\Enums\SettlementRail;

it('has expected cases', function () {
    expect(SettlementRail::INSTAPAY->value)->toBe('INSTAPAY');
    expect(SettlementRail::PESONET->value)->toBe('PESONET');
    expect(SettlementRail::cases())->toHaveCount(2);
});

it('can be created from string value', function () {
    expect(SettlementRail::from('INSTAPAY'))->toBe(SettlementRail::INSTAPAY);
    expect(SettlementRail::from('PESONET'))->toBe(SettlementRail::PESONET);
});
