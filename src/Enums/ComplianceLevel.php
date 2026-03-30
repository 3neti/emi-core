<?php

namespace LBHurtado\EmiCore\Enums;

enum ComplianceLevel: string
{
    case Rejected = '-1';
    case None = '0';
    case Level1 = '1';
    case Level2 = '2';
    case Level3 = '3';
    case Level4 = '4';
}
