<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Contracts\FundingInstructionIssuer;
use LBHurtado\EmiCore\Contracts\FundingProviderAdapter;
use LBHurtado\EmiCore\Contracts\ProviderFundingEvidenceVerifier;
use LBHurtado\EmiCore\Contracts\SettlementProviderCapability;
use LBHurtado\EmiCore\Contracts\StandingFundingAddressProvider;

it('separates provider capabilities without breaking legacy funding adapters', function () {
    $funding = new ReflectionClass(FundingProviderAdapter::class);
    $standing = new ReflectionClass(StandingFundingAddressProvider::class);

    expect($funding->implementsInterface(FundingInstructionIssuer::class))->toBeTrue()
        ->and($funding->implementsInterface(ProviderFundingEvidenceVerifier::class))->toBeTrue()
        ->and($funding->hasMethod('authenticateWebhook'))->toBeTrue()
        ->and($standing->implementsInterface(SettlementProviderCapability::class))->toBeTrue();
});
