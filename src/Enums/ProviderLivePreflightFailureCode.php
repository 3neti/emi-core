<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Enums;

enum ProviderLivePreflightFailureCode: string
{
    case DnsResolutionFailed = 'dns_resolution_failed';
    case ConnectionTimeout = 'connection_timeout';
    case TlsFailure = 'tls_failure';
    case AuthenticationFailed = 'authentication_failed';
    case BalanceEndpointRejected = 'balance_endpoint_rejected';
    case InvalidBalanceResponse = 'invalid_balance_response';
    case ProviderUnavailable = 'provider_unavailable';
}
