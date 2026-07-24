<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Enums;

enum ProviderCapability: string
{
    case ReadinessProbe = 'readiness_probe';
    case BalanceRead = 'balance_read';
    case FundingEvidenceRead = 'funding_evidence_read';
    case FundingInstructionIssue = 'funding_instruction_issue';
    case StandingFundingAddress = 'standing_funding_address';
    case AccountProvisioning = 'account_provisioning';
    case SettlementExecution = 'settlement_execution';
    case Reconciliation = 'reconciliation';
}
