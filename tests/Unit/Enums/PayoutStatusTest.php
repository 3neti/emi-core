<?php

use LBHurtado\EmiCore\Enums\PayoutStatus;

it('has expected cases', function () {
    expect(PayoutStatus::cases())->toHaveCount(6);
    expect(PayoutStatus::PENDING->value)->toBe('pending');
    expect(PayoutStatus::COMPLETED->value)->toBe('completed');
    expect(PayoutStatus::FAILED->value)->toBe('failed');
});

it('maps generic statuses correctly', function () {
    expect(PayoutStatus::fromGeneric('pending'))->toBe(PayoutStatus::PENDING);
    expect(PayoutStatus::fromGeneric('processing'))->toBe(PayoutStatus::PROCESSING);
    expect(PayoutStatus::fromGeneric('completed'))->toBe(PayoutStatus::COMPLETED);
    expect(PayoutStatus::fromGeneric('failed'))->toBe(PayoutStatus::FAILED);
    expect(PayoutStatus::fromGeneric('cancelled'))->toBe(PayoutStatus::CANCELLED);
    expect(PayoutStatus::fromGeneric('refunded'))->toBe(PayoutStatus::REFUNDED);
});

it('identifies final and pending states', function () {
    expect(PayoutStatus::COMPLETED->isFinal())->toBeTrue();
    expect(PayoutStatus::FAILED->isFinal())->toBeTrue();
    expect(PayoutStatus::PENDING->isFinal())->toBeFalse();
    expect(PayoutStatus::PENDING->isPending())->toBeTrue();
    expect(PayoutStatus::PROCESSING->isPending())->toBeTrue();
});
