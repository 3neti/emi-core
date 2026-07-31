<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Configuration\ProviderConnectionTemplateData;

interface DeploymentConnectionContributor
{
    public function providerCode(): string;

    /**
     * @return list<ProviderConnectionTemplateData>
     */
    public function connectionTemplates(): array;
}
