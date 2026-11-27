# QR Artifact and On-Demand Decode Contract

## Purpose

This document explains the QR contract added for provider-neutral consumers and
future agents.

## Generated QR artifact

`FundingQrCodeData::base64Payload` is the provider-generated QR artifact. For
NetBank QR Ph funding, it is a Base64-encoded PNG returned by the provider's
generation endpoint. Consumers may convert it to an image for display.

The separate NetBank `qr_string` belongs to the QR decode flow. It is not
implicitly present in generated funding instructions.

## Optional display content

`FundingQrCodeData::displayContent` is nullable and optional. It is reserved for
a provider that separately documents machine-readable QR content and its
format. Supported formats are:

- `payment_url`
- `emv_payload`
- `provider_payload`

Do not populate this field by decoding or inspecting the PNG. Do not invent a
payment URL or wrapper payload.

## On-demand decode capability

Providers may implement `FundingQrCodeDecoder`:

```php
FundingQrDecodeResultData decode(FundingQrCodeData $qrCode);
```

The result contains the decoded `qrString` and provider-confirmed metadata.
Decoding is explicit and on demand; it is not part of QR generation.

Consumers must authorize the operation, rate-limit it, avoid logging raw QR
content, and treat provider metadata as sensitive payment information.

## Compatibility

The `displayContent` property is appended to the DTO with a `null` default, so
existing constructors and PNG-only providers remain compatible. Providers that
do not implement the decoder capability continue to work normally.

## Release order

Release `emi-core` first. Provider adapters then update their Core dependency,
implement optional capabilities, and release afterward. Host applications only
consume the capability when explicitly configured and authorized.
