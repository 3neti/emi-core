<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Enums;

enum FundingAddressPurpose: string
{
    case AccountFunding = 'account_funding';
    case FundingIntent = 'funding_intent';
    case Payment = 'payment';
}
