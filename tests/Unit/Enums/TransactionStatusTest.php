<?php

use LBHurtado\EmiCore\Enums\TransactionStatus;

it('has all expected transaction status cases', function () {
    $cases = TransactionStatus::cases();

    expect($cases)->toHaveCount(12)
        ->and(TransactionStatus::Initiated->value)->toBe('initiated')
        ->and(TransactionStatus::Settled->value)->toBe('settled')
        ->and(TransactionStatus::Withheld->value)->toBe('withheld');
});

it('can be created from string value', function () {
    expect(TransactionStatus::from('otp_required'))
        ->toBe(TransactionStatus::OtpRequired);
});
