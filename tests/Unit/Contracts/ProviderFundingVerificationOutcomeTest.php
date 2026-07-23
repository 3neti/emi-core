<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Exceptions\ProviderFundingNotObserved;
use LBHurtado\EmiCore\Exceptions\ProviderFundingVerificationIndeterminate;

it('distinguishes an absent provider observation from indeterminate evidence', function () {
    expect(new ProviderFundingNotObserved('not observed'))->toBeInstanceOf(RuntimeException::class)
        ->and(new ProviderFundingVerificationIndeterminate('indeterminate'))->toBeInstanceOf(RuntimeException::class)
        ->and(ProviderFundingNotObserved::class)->not->toBe(ProviderFundingVerificationIndeterminate::class);
});
