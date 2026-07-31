# Upgrading 3neti/emi-core

## 2.0 beta

The 2.0 line introduces the provider-neutral settlement capability kernel,
append-only funding observations, hardened webhook evidence, standing funding
addresses, and sanitized live-provider preflight results.

### Webhook provider codes

`WebhookReceipt::provider_code` is now returned as a canonical string rather
than `ProviderCode`.

The former enum cast made webhook evidence depend on a closed list of
providers. That prevented a newly installed bank or EMI adapter from recording
evidence until emi-core itself added another enum case. Provider adapters must
now use their stable canonical code and consumers must compare the string:

```php
$receipt->provider_code === 'netbank';
```

Code that previously accessed `$receipt->provider_code->value` must be updated.
The legacy `ProviderCode` enum remains in use by the original wallet,
transaction, and provider-account model surface.

### Webhook evidence is immutable

Provider evidence attributes on `WebhookReceipt` cannot be changed after
creation. Processing state and sanitized failure information may still advance.
Corrections must be represented by new evidence or a new normalized observation
revision; do not rewrite provider facts.

Sensitive receipt fields are hidden from serialization. Raw bodies, signatures,
headers, credentials, and account identifiers must not be exposed through
application read models or logs.

### Migrations

The 2.0 beta adds provider funding observations and hardens the existing
webhook-receipt table. emi-core migrations remain publish-only:

```bash
php artisan vendor:publish --tag=emi-core-migrations
php artisan migrate
```

Review published migrations against the host schema before running them. The
package does not auto-load migrations because historical EMI wallet tables may
overlap with the host's accounting package.

### Provider integrations

Provider packages should implement only the capability contracts they support
and publish a `ProviderCapabilityManifestData`. Applications must resolve these
capabilities through `SettlementProviderRegistryContract` and fail closed when
a required capability is absent or not ready.

`ProviderLivePreflightFailureCode` is intentionally sanitized. Do not replace
its values with raw network exceptions or provider response bodies.

### Compatibility

The supported matrix is:

- PHP 8.3 or 8.4;
- Laravel 12 or 13;
- Orchestra Testbench 10 or 11; and
- Pest 3 or 4 for package development.

The 2.0 beta should be adopted through an explicit pre-release constraint until
the provider and application consumer suites have completed their release
gates.
