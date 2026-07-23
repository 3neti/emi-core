<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Funding\FundingDestinationData;
use LBHurtado\EmiCore\Data\Funding\FundingInstructionRequestData;
use LBHurtado\EmiCore\Data\Funding\FundingVerificationData;

it('carries an immutable provider funding destination through instruction and verification requests', function () {
    $destination = new FundingDestinationData(
        provider: 'netbank',
        mode: 'dedicated',
        destinationType: 'bank_account',
        accountReference: 'wallet:01JABC',
        displayReference: '•••• 1234 · VCA 54321',
        fingerprint: hash('sha256', 'netbank|1234|54321'),
        verificationStatus: 'verified',
        providerAccountId: 'account-1234',
        bankAccountNumber: '00001234',
        bankAccountName: 'Treasury Operations',
        routingAlias: '54321',
        routingCredential: 'write-only-token',
    );

    $instruction = new FundingInstructionRequestData(
        provider: 'netbank',
        fundingReference: 'FUND-001',
        amountMinor: 2500,
        currency: 'PHP',
        accountReference: 'wallet:01JABC',
        destination: $destination,
    );

    $verification = new FundingVerificationData(
        provider: 'netbank',
        fundingIntentReference: 'FUND-001',
        expectedAmountMinor: 2500,
        currency: 'PHP',
        destination: $destination,
    );

    expect($instruction->destination)->toBe($destination)
        ->and($verification->destination)->toBe($destination)
        ->and($destination->routingCredential)->toBe('write-only-token')
        ->and($destination->metadata)->toBe([]);
});

it('keeps funding destination optional for backwards compatibility', function () {
    $instruction = new FundingInstructionRequestData(
        provider: 'paynamics',
        fundingReference: 'FUND-002',
        amountMinor: 2500,
        currency: 'PHP',
        accountReference: 'wallet:01JDEF',
    );

    $verification = new FundingVerificationData(
        provider: 'paynamics',
        fundingIntentReference: 'FUND-002',
        expectedAmountMinor: 2500,
        currency: 'PHP',
    );

    expect($instruction->destination)->toBeNull()
        ->and($verification->destination)->toBeNull();
});
