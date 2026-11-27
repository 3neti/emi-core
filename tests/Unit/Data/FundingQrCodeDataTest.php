<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Funding\FundingInstructionsData;
use LBHurtado\EmiCore\Data\Funding\FundingQrCodeData;
use LBHurtado\EmiCore\Data\Funding\FundingQrDisplayContentData;
use LBHurtado\EmiCore\Data\Funding\FundingQrDisplayContentFormat;
use LBHurtado\EmiCore\Data\Funding\FundingQrDecodeResultData;

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
        'displayContent' => null,
    ]);
});

it('serializes optional provider display content without changing the png artifact', function () {
    $qrCode = new FundingQrCodeData(
        mimeType: 'image/png',
        base64Payload: 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAAB',
        qrMode: 'dynamic',
        transactionType: 'p2p',
        embeddedAmount: true,
        providerGenerated: true,
        displayContent: new FundingQrDisplayContentData(
            format: FundingQrDisplayContentFormat::EmvPayload,
            value: '000201010212...',
        ),
    );

    expect($qrCode->toArray()['displayContent'])->toBe([
        'format' => 'emv_payload',
        'value' => '000201010212...',
        'providerGenerated' => true,
    ])->and($qrCode->base64Payload)->toBe('iVBORw0KGgoAAAANSUhEUgAAAAEAAAAB');
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

it('serializes an on-demand qr decode result without changing the qr artifact contract', function () {
    $result = new FundingQrDecodeResultData(
        qrString: '000201010212...',
        providerData: ['qr_type' => 'Dynamic'],
    );

    expect($result->toArray())->toBe([
        'qrString' => '000201010212...',
        'providerData' => ['qr_type' => 'Dynamic'],
    ]);
});
