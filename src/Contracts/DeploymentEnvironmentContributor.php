<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\Configuration\EnvironmentVariableData;

interface DeploymentEnvironmentContributor
{
    /**
     * @return list<EnvironmentVariableData>
     */
    public function environmentVariables(): array;
}
