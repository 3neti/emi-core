<?php

use LBHurtado\EmiCore\Enums\TransactionDirection;
use LBHurtado\EmiCore\Enums\TransactionStatus;
use LBHurtado\EmiCore\Enums\TransactionType;
use LBHurtado\EmiCore\Models\Transaction;
use LBHurtado\EmiCore\Models\Transfer;
use LBHurtado\EmiCore\Models\Wallet;

it('can create a transaction with all casts', function () {
    $wallet = Wallet::create([
        'provider_code' => 'paynamics_constellation',
        'provider_wallet_id' => 'CNSTWLLT000010',
        'wallet_type' => 'customer',
    ]);

    $txn = Transaction::create([
        'wallet_id' => $wallet->id,
        'provider_code' => 'paynamics_constellation',
        'request_id' => 'REQ-'.uniqid(),
        'transaction_type' => 'transfer',
        'direction' => 'internal',
        'status' => 'initiated',
        'amount' => 1000.00,
        'fee' => 10.00,
        'final_amount' => 990.00,
    ]);

    expect($txn->transaction_type)->toBe(TransactionType::Transfer)
        ->and($txn->direction)->toBe(TransactionDirection::Internal)
        ->and($txn->status)->toBe(TransactionStatus::Initiated)
        ->and($txn->amount)->toBe('1000.00');
});

it('has source and destination wallet relationships', function () {
    $source = Wallet::create([
        'provider_code' => 'paynamics_constellation',
        'provider_wallet_id' => 'CNSTWLLTSRC001',
        'wallet_type' => 'merchant',
    ]);

    $dest = Wallet::create([
        'provider_code' => 'paynamics_constellation',
        'provider_wallet_id' => 'CNSTWLLTDST001',
        'wallet_type' => 'customer',
    ]);

    $txn = Transaction::create([
        'source_wallet_id' => $source->id,
        'destination_wallet_id' => $dest->id,
        'provider_code' => 'paynamics_constellation',
        'request_id' => 'REQ-'.uniqid(),
        'transaction_type' => 'transfer',
        'direction' => 'internal',
        'amount' => 500.00,
    ]);

    expect($txn->sourceWallet->provider_wallet_id)->toBe('CNSTWLLTSRC001')
        ->and($txn->destinationWallet->provider_wallet_id)->toBe('CNSTWLLTDST001');
});

it('has a transfer detail record', function () {
    $txn = Transaction::create([
        'provider_code' => 'paynamics_constellation',
        'request_id' => 'REQ-'.uniqid(),
        'transaction_type' => 'transfer',
        'direction' => 'internal',
        'amount' => 200.00,
    ]);

    $transfer = Transfer::create([
        'transaction_id' => $txn->id,
        'pre_transfer_reference' => 'PRE-REF-001',
        'is_phantom_destination' => false,
    ]);

    expect($transfer->transaction->id)->toBe($txn->id)
        ->and($transfer->pre_transfer_reference)->toBe('PRE-REF-001')
        ->and($transfer->is_phantom_destination)->toBeFalse();
});
