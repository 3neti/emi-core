# 3neti/emi-core

Provider-neutral settlement contracts, normalized evidence, and persistence
primitives for Laravel. Provider packages such as `3neti/emi-netbank` implement
these boundaries; applications such as `3neti/x-change` orchestrate them.

## Requirements

- PHP 8.3+
- Laravel 12 or 13

## Installation

```bash
composer require 3neti/emi-core
```

The package auto-discovers `EmiCoreServiceProvider`. Publish configuration only
when the host needs to override the defaults:

```bash
php artisan vendor:publish --tag=emi-core-config
```

Migrations are deliberately not loaded automatically because some historical
EMI tables can overlap with an application's wallet tables. Publish and review
them before migrating:

```bash
php artisan vendor:publish --tag=emi-core-migrations
php artisan migrate
```

## Provider contract

The current settlement kernel separates provider capabilities instead of
assuming every bank or EMI supports the same operations:

- readiness and live preflight;
- authoritative balance reads;
- funding instructions and standing funding addresses;
- immutable funding evidence;
- provider account provisioning;
- settlement execution; and
- reconciliation.

Provider packages register capability manifests with the settlement provider
registry. A host must fail closed when a required provider or capability is
unknown, disabled, or not ready.

### Live preflight failures

`ProviderLivePreflightFailureCode` is the provider-neutral, sanitized failure
taxonomy shared with provider adapters:

- DNS resolution failure;
- connection timeout;
- TLS failure;
- authentication failure;
- balance-endpoint rejection;
- invalid balance response; and
- provider unavailable.

Provider packages must not place credentials, account numbers, raw response
bodies, or other secrets in these results.

## Funding evidence

Webhook receipts retain pristine provider evidence while normalized funding
observations are append-only and versioned. A webhook permits intake only; it
does not authorize account credit. The consuming application must independently
verify provider evidence and perform its own atomic accounting entry.

Normalized money uses integer minor units. Provider references remain opaque,
and corrections create new normalization revisions instead of rewriting prior
observations.

## Legacy EMI model surface

The package also contains the original provider-neutral EMI models and
interfaces retained for existing consumers.

### Legacy contracts

Provider adapters must implement these interfaces:

- `WalletProvider` — wallet CRUD (add merchant/customer, get details/balance, edit)
- `TransferProvider` — staged transfers (pre-transfer, settle, cancel)
- `CashInProvider` — inbound funding
- `CashOutProvider` — outbound disbursement + OTP verification
- `SignsProviderPayloads` — request signature generation
- `VerifiesProviderPostbacks` — webhook/postback signature verification

### Legacy enums

- `ProviderCode` — registered legacy EMI providers
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

## Configuration

```dotenv
EMI_DEFAULT_PROVIDER=
EMI_READINESS_CACHE_TTL=300
```

Provider selection belongs to the host application. Credentials and endpoints
belong to the provider package or deployment environment and must never be
committed here.

## Testing

```bash
composer install
composer test
```

The supported compatibility matrix is PHP 8.3 and 8.4 on Laravel 12 and 13.

## License

Proprietary. Deployment requires authorized access to the private package
repository.
