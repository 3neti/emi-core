<?php

declare(strict_types=1);

use LBHurtado\EmiCore\Data\Configuration\ProviderConnectionTemplateData;
use LBHurtado\EmiCore\Enums\ProviderCapability;

it('describes a provider-neutral connection template', function (): void {
    $template = new ProviderConnectionTemplateData(
        reference: 'bank-primary',
        provider: 'example-bank',
        currency: 'PHP',
        inventoryReference: 'inventory:example-bank:php',
        settlementResourceReference: 'account:example-bank:primary',
        settlementResourceType: 'bank_account',
        custodyMode: 'pooled',
        requiredCapabilities: [ProviderCapability::SettlementExecution],
    );

    expect($template->provider)->toBe('example-bank')
        ->and($template->requiredCapabilities)->toBe([ProviderCapability::SettlementExecution]);
});

it('rejects malformed connection templates', function (): void {
    expect(fn () => new ProviderConnectionTemplateData(
        reference: 'bank-primary',
        provider: 'Bad Bank',
        currency: 'PHP',
        inventoryReference: 'inventory:bank:php',
        settlementResourceReference: 'account:bank:primary',
        settlementResourceType: 'bank_account',
        custodyMode: 'pooled',
        requiredCapabilities: [],
    ))->toThrow(InvalidArgumentException::class);
});
