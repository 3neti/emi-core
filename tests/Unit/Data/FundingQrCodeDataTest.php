<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Funding\FundingInstructionsData;
use LBHurtado\EmiCore\Data\Funding\FundingQrCodeData;

it('serializes normalized provider qr instructions', function () {
    $qrCode = new FundingQrCodeData(
        mimeType: 'image/png',
        base64Payload: 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAAB',
        qrMode: 'dynamic',
        transactionType: 'p2m',
        embeddedAmount: true,
        providerGenerated: true,
    );

    $instructions = new FundingInstructionsData(
        provider: 'netbank',
        providerReference: 'FUND-001',
        amountMinor: 2_500,
        currency: 'PHP',
        qrCode: $qrCode,
    );

    expect($instructions->toArray()['qrCode'])->toBe([
        'mimeType' => 'image/png',
        'base64Payload' => 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAAB',
        'qrMode' => 'dynamic',
        'transactionType' => 'p2m',
        'embeddedAmount' => true,
        'providerGenerated' => true,
    ]);
});

it('keeps qr instructions optional for existing funding adapters', function () {
    $instructions = new FundingInstructionsData(
        provider: 'paynamics',
        providerReference: 'FUND-002',
        amountMinor: 2_500,
        currency: 'PHP',
    );

    expect($instructions->qrCode)->toBeNull()
        ->and($instructions->toArray()['qrCode'])->toBeNull();
});
