<?php

namespace LBHurtado\EmiCore\Enums;

enum TransactionDirection: string
{
    case Inbound = 'inbound';
    case Outbound = 'outbound';
    case Internal = 'internal';
}
