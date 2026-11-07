<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\PayoutIdentityRequirementsData;

interface PayoutIdentityRequirementsProvider
{
    public function payoutIdentityRequirements(string $rail): PayoutIdentityRequirementsData;
}
