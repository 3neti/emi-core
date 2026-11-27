<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Funding;

enum FundingQrDisplayContentFormat: string
{
    case PaymentUrl = 'payment_url';
    case EmvPayload = 'emv_payload';
    case ProviderPayload = 'provider_payload';
}
