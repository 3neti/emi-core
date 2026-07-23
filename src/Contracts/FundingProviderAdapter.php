<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\FundingInstructionRequestData;
use LBHurtado\EmiCore\Data\Funding\FundingInstructionsData;
use LBHurtado\EmiCore\Data\Funding\FundingVerificationData;
use LBHurtado\EmiCore\Data\Funding\ProviderEventHintData;
use LBHurtado\EmiCore\Data\Funding\ProviderFundingObservationData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookReceiptData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookRequestData;
use LBHurtado\EmiCore\Data\Funding\WebhookAuthenticationData;

interface FundingProviderAdapter
{
    public function providerCode(): string;

    public function createFundingInstructions(FundingInstructionRequestData $request): FundingInstructionsData;

    public function authenticateWebhook(ProviderWebhookRequestData $request): WebhookAuthenticationData;

    public function normalizeWebhook(ProviderWebhookReceiptData $receipt): ProviderEventHintData;

    public function verifyFunding(FundingVerificationData $verification): ProviderFundingObservationData;
}
