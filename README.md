# lbhurtado/emi-core

Provider-agnostic EMI (Electronic Money Issuer) domain package for Laravel. Defines the shared contracts, enums, models, and events that any EMI provider adapter can implement.

## Requirements

- PHP 8.3+
- Laravel 12 or 13

## Installation

```bash
composer require lbhurtado/emi-core
```

The package auto-discovers its service provider. Publish the config if needed:

```bash
php artisan vendor:publish --tag=emi-core-config
```

## What's Included

### Contracts

Provider adapters must implement these interfaces:

- `WalletProvider` — wallet CRUD (add merchant/customer, get details/balance, edit)
- `TransferProvider` — staged transfers (pre-transfer, settle, cancel)
- `CashInProvider` — inbound funding
- `CashOutProvider` — outbound disbursement + OTP verification
- `SignsProviderPayloads` — request signature generation
- `VerifiesProviderPostbacks` — webhook/postback signature verification

### Enums

- `ProviderCode` — registered EMI providers (currently: `paynamics_constellation`)
- `WalletType` — merchant, customer, phantom
- `WalletStatus` — active, locked, suspended, closed
- `ComplianceLevel` — KYC levels (-1 through 4)
- `VerificationStatus` — PENDING, FOR REVIEW, REJECTED, APPROVED, RECAPTURE
- `TransactionType` — cash_in, cash_out, transfer, airtime_load, bills_payment
- `TransactionStatus` — 12 states from `initiated` through `reconciling`
- `TransactionDirection` — inbound, outbound, internal

### Models

All models use enum casts and proper Eloquent relationships:

| Model | Purpose |
|---|---|
| `ProviderAccount` | API credentials per provider/tenant |
| `Wallet` | Local mirror of provider wallet |
| `WalletProfile` | Personal/business identity fields |
| `WalletLimitSnapshot` | Captured limit fields at a point in time |
| `Transaction` | Master transaction mirror (indexed by `request_id`) |
| `Transfer` | Pre-transfer/settle/cancel lifecycle detail |
| `CashIn` | Cash-in detail (payment method, channel, sender) |
| `CashOut` | Cash-out detail (bank account, OTP status) |
| `BankAccount` | Linked settlement/disbursement bank accounts |
| `OtpChallenge` | OTP verification trail for cash-out |
| `WebhookReceipt` | Raw postback payload + signature verification |
| `ReconciliationEntry` | Local vs provider status drift detection |

### Key Design Decisions

- **request_id as first-class key** — all transactions are uniquely indexed by `request_id` for idempotency and reconciliation
- **Enum casts everywhere** — wallet type, status, compliance level, transaction status all use PHP 8.1 backed enums
- **Provider-agnostic models** — models don't depend on any specific provider; the `provider_code` field identifies which adapter created them
- **Async-first mindset** — `TransactionStatus` includes states like `awaiting_provider`, `otp_required`, and `reconciling` for asynchronous provider flows

## Testing

```bash
# From the monorepo host
composer test:emi-core
```

## License

Proprietary — Lester Hurtado
