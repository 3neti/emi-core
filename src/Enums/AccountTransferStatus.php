<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Enums;

enum AccountTransferStatus: string
{
    case Pending = 'pending';
    case Settled = 'settled';
    case Rejected = 'rejected';
    case Uncertain = 'uncertain';
}
