<?php

namespace LBHurtado\EmiCore\Enums;

enum TransactionStatus: string
{
    case Initiated = 'initiated';
    case AwaitingProvider = 'awaiting_provider';
    case OtpRequired = 'otp_required';
    case Verified = 'verified';
    case PendingSettlement = 'pending_settlement';
    case Settled = 'settled';
    case Cancelled = 'cancelled';
    case Failed = 'failed';
    case Expired = 'expired';
    case Reversed = 'reversed';
    case Withheld = 'withheld';
    case Reconciling = 'reconciling';
}
