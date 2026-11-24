<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Providers\AccountTransferRequestData;
use LBHurtado\EmiCore\Enums\AccountTransferStatus;

it('retains the exact integer amount and distinct account routing', function (): void {
    $request = new AccountTransferRequestData('netbank', 'transfer-1', 'stable-key', '111-111-11111-1', 'customer-1', '222-222-22222-2', 1000, 'PHP', 'Source', 'Reserve', 'NETBANK');
    expect($request->amountMinor)->toBe(1000)->and($request->sourceAccountNumber)->toBe('111-111-11111-1');
    expect(AccountTransferStatus::Uncertain->value)->toBe('uncertain');
});

it('rejects invalid amounts and matching bank accounts', function (): void {
    expect(fn () => new AccountTransferRequestData('netbank', 'transfer-1', 'stable-key', '111-111-11111-1', 'customer-1', '222-222-22222-2', 0, 'PHP', 'Source', 'Reserve', 'NETBANK'))->toThrow(InvalidArgumentException::class);
    expect(fn () => new AccountTransferRequestData('netbank', 'transfer-1', 'stable-key', '111-111-11111-1', 'customer-1', '111111111111', 1000, 'PHP', 'Source', 'Reserve', 'NETBANK'))->toThrow(InvalidArgumentException::class);
});
