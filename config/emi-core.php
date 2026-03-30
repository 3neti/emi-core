<?php

return [
    // Provider selection belongs in the host app, not in emi-core.
    // Set via EMI_DEFAULT_PROVIDER env var or host app config.
    'default_provider' => env('EMI_DEFAULT_PROVIDER'),
    'readiness_cache_ttl' => env('EMI_READINESS_CACHE_TTL', 300),
];
