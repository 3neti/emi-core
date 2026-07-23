<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Funding\FundingQrCodeData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressRequestData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingObservationRequestData;
use LBHurtado\EmiCore\Enums\FundingAddressPurpose;

it('serializes the three address purposes without provider-specific fields', function (
    FundingAddressPurpose $purpose,
) {
    $request = new StandingFundingAddressRequestData(
        ownerReference: 'App\\Models\\User:5',
        accountReference: 'App\\Models\\User:5',
        purpose: $purpose,
        currency: 'PHP',
    );

    expect($request->toArray())->toMatchArray([
        'ownerReference' => 'App\\Models\\User:5',
        'accountReference' => 'App\\Models\\User:5',
        'purpose' => $purpose->value,
        'currency' => 'PHP',
        'destination' => null,
    ]);
})->with(FundingAddressPurpose::cases());

it('carries reusable qr instructions without granting settlement authority', function () {
    $address = new StandingFundingAddressData(
        provider: 'netbank',
        providerReference: 'standing:netbank:owner-5',
        fundingAddress: '915001234567890123456',
        accountReference: 'App\\Models\\User:5',
        purpose: FundingAddressPurpose::AccountFunding,
        currency: 'PHP',
        qrCode: new FundingQrCodeData(
            mimeType: 'image/png',
            base64Payload: 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAAB',
            qrMode: 'static',
            transactionType: 'p2m',
            embeddedAmount: false,
            providerGenerated: true,
        ),
    );

    expect($address->toArray())->toMatchArray([
        'provider' => 'netbank',
        'providerReference' => 'standing:netbank:owner-5',
        'fundingAddress' => '915001234567890123456',
        'accountReference' => 'App\\Models\\User:5',
        'purpose' => 'account_funding',
        'currency' => 'PHP',
        'reusable' => true,
    ])->and($address->toArray())
        ->not->toHaveKeys(['automaticCreditEnabled', 'walletBalance', 'settled']);
});

it('requires an explicit purpose when checking a standing address', function () {
    $request = new StandingFundingObservationRequestData(
        fundingAddress: '915001234567890123456',
        accountReference: 'App\\Models\\User:5',
        purpose: FundingAddressPurpose::Payment,
        currency: 'PHP',
        verificationSource: 'schedule',
    );

    expect($request->purpose)->toBe(FundingAddressPurpose::Payment)
        ->and($request->verificationSource)->toBe('schedule');
});
