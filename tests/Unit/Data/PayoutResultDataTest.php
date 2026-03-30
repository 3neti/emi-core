<?php

use LBHurtado\EmiCore\Data\PayoutResultData;
use LBHurtado\EmiCore\Enums\PayoutStatus;

it('can be constructed', function () {
    $data = new PayoutResultData(
        transaction_id: 'TXN-123',
        uuid: 'uuid-abc',
        status: PayoutStatus::COMPLETED,
    );

    expect($data->transaction_id)->toBe('TXN-123');
    expect($data->uuid)->toBe('uuid-abc');
    expect($data->status)->toBe(PayoutStatus::COMPLETED);
    expect($data->metadata)->toBeNull();
});

it('serializes to array', function () {
    $data = new PayoutResultData(
        transaction_id: 'TXN-123',
        uuid: 'uuid-abc',
        status: PayoutStatus::PENDING,
        metadata: ['raw' => 'data'],
    );

    $array = $data->toArray();
    expect($array)->toHaveKeys(['transaction_id', 'uuid', 'status', 'metadata']);
});
