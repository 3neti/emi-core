<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Contracts\FundingProviderAdapter;
use LBHurtado\EmiCore\Data\Funding\FundingInstructionRequestData;
use LBHurtado\EmiCore\Data\Funding\FundingInstructionsData;
use LBHurtado\EmiCore\Data\Funding\FundingVerificationData;
use LBHurtado\EmiCore\Data\Funding\ProviderEventHintData;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookReceiptData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookRequestData;
use LBHurtado\EmiCore\Data\Funding\WebhookAuthenticationData;

it('defines a provider-neutral funding boundary without a balance credit method', function () {
    $contract = new ReflectionClass(FundingProviderAdapter::class);

    expect($contract->getMethod('createFundingInstructions')->getParameters()[0]->getType()?->getName())
        ->toBe(FundingInstructionRequestData::class)
        ->and($contract->getMethod('createFundingInstructions')->getReturnType()?->getName())
        ->toBe(FundingInstructionsData::class)
        ->and($contract->getMethod('authenticateWebhook')->getParameters()[0]->getType()?->getName())
        ->toBe(ProviderWebhookRequestData::class)
        ->and($contract->getMethod('authenticateWebhook')->getReturnType()?->getName())
        ->toBe(WebhookAuthenticationData::class)
        ->and($contract->getMethod('normalizeWebhook')->getParameters()[0]->getType()?->getName())
        ->toBe(ProviderWebhookReceiptData::class)
        ->and($contract->getMethod('normalizeWebhook')->getReturnType()?->getName())
        ->toBe(ProviderEventHintData::class)
        ->and($contract->getMethod('verifyFunding')->getParameters()[0]->getType()?->getName())
        ->toBe(FundingVerificationData::class)
        ->and($contract->getMethod('verifyFunding')->getReturnType()?->getName())
        ->toBe(ProviderFundingObservationData::class)
        ->and($contract->hasMethod('credit'))
        ->toBeFalse()
        ->and($contract->hasMethod('fund'))
        ->toBeFalse();
});
