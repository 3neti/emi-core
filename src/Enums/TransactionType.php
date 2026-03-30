<?php

namespace LBHurtado\EmiCore\Enums;

enum TransactionType: string
{
    case CashIn = 'cash_in';
    case CashOut = 'cash_out';
    case Transfer = 'transfer';
    case AirtimeLoad = 'airtime_load';
    case BillsPayment = 'bills_payment';
}
