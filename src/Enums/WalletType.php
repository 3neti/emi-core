<?php

namespace LBHurtado\EmiCore\Enums;

enum WalletType: string
{
    case Merchant = 'merchant';
    case Customer = 'customer';
    case Phantom = 'phantom';
}
