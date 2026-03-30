<?php

namespace LBHurtado\EmiCore\Enums;

enum WalletStatus: string
{
    case Active = 'active';
    case Locked = 'locked';
    case Suspended = 'suspended';
    case Closed = 'closed';
}
