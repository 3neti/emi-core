<?php

namespace LBHurtado\EmiCore\Contracts;

use LBHurtado\EmiCore\Data\SystemReadinessResult;

interface SystemReadiness
{
    public function check(): SystemReadinessResult;
}
