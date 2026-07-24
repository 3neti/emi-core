<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Providers;

use InvalidArgumentException;
use LBHurtado\EmiCore\Enums\ProviderCapability;
use Spatie\LaravelData\Data;

class ProviderCapabilityManifestData extends Data
{
    /**
     * @param  list<ProviderCapability>  $capabilities
     */
    public function __construct(
        public string $provider,
        public string $label,
        public array $capabilities,
    ) {
        $this->provider = mb_strtolower(trim($provider));
        $this->label = trim($label);
        $this->capabilities = array_values(array_unique($capabilities, SORT_REGULAR));

        if (preg_match('/^[a-z][a-z0-9_-]*$/', $this->provider) !== 1) {
            throw new InvalidArgumentException(
                'Provider codes must be canonical lower-case identifiers.',
            );
        }

        if ($this->label === '') {
            throw new InvalidArgumentException('A provider label is required.');
        }
    }

    public function supports(ProviderCapability $capability): bool
    {
        return in_array($capability, $this->capabilities, true);
    }
}
