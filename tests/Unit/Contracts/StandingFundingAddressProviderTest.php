<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Contracts\StandingFundingAddressProvider;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingAddressRequestData;
use LBHurtado\EmiCore\Data\Funding\StandingFundingObservationRequestData;

it('defines a provider-neutral standing funding address boundary without a balance mutation method', function () {
    $contract = new ReflectionClass(StandingFundingAddressProvider::class);

    expect($contract->getMethod('providerCode')->getReturnType()?->getName())
        ->toBe('string')
        ->and($contract->getMethod('createStandingFundingAddress')->getParameters()[0]->getType()?->getName())
        ->toBe(StandingFundingAddressRequestData::class)
        ->and($contract->getMethod('createStandingFundingAddress')->getReturnType()?->getName())
        ->toBe(StandingFundingAddressData::class)
        ->and($contract->getMethod('observeStandingFundingAddress')->getParameters()[0]->getType()?->getName())
        ->toBe(StandingFundingObservationRequestData::class)
        ->and($contract->getMethod('observeStandingFundingAddress')->getReturnType()?->getName())
        ->toBe('array')
        ->and($contract->hasMethod('credit'))
        ->toBeFalse()
        ->and($contract->hasMethod('settle'))
        ->toBeFalse();
});

it('requires observations to remain provider evidence rather than account credits', function () {
    $method = new ReflectionMethod(StandingFundingAddressProvider::class, 'observeStandingFundingAddress');

    expect($method->getDocComment())
        ->toContain('list<ProviderFundingObservationData>')
        ->and(ProviderFundingObservationData::class)
        ->toBeString();
});
