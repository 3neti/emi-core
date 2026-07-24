<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Funding\ProviderEventHintData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookReceiptData;
use LBHurtado\EmiCore\Data\Funding\ProviderWebhookRequestData;
use LBHurtado\EmiCore\Data\Funding\WebhookAuthenticationData;

interface FundingProviderAdapter extends FundingInstructionIssuer, ProviderFundingEvidenceVerifier
{
    public function authenticateWebhook(ProviderWebhookRequestData $request): WebhookAuthenticationData;

    public function normalizeWebhook(ProviderWebhookReceiptData $receipt): ProviderEventHintData;
}
