<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Configuration;

use InvalidArgumentException;
use LBHurtado\EmiCore\Enums\ProviderCapability;

final readonly class ProviderConnectionTemplateData
{
    /**
     * @param  list<ProviderCapability>  $requiredCapabilities
     */
    public function __construct(
        public string $reference,
        public string $provider,
        public string $currency,
        public string $inventoryReference,
        public string $settlementResourceReference,
        public string $settlementResourceType,
        public string $custodyMode,
        public array $requiredCapabilities,
        public int $decimalPlaces = 2,
    ) {
        if (preg_match('/^[a-z][a-z0-9_-]*$/', $this->provider) !== 1) {
            throw new InvalidArgumentException("Provider code [{$this->provider}] is invalid.");
        }

        if (preg_match('/^[A-Z]{3}$/', $this->currency) !== 1) {
            throw new InvalidArgumentException("Currency [{$this->currency}] is invalid.");
        }

        foreach ([
            $this->reference,
            $this->inventoryReference,
            $this->settlementResourceReference,
            $this->settlementResourceType,
            $this->custodyMode,
        ] as $value) {
            if (trim($value) === '') {
                throw new InvalidArgumentException('Provider connection references cannot be empty.');
            }
        }

        foreach ($this->requiredCapabilities as $capability) {
            if (! $capability instanceof ProviderCapability) {
                throw new InvalidArgumentException('Provider capabilities must use ProviderCapability values.');
            }
        }

        if ($this->decimalPlaces < 0 || $this->decimalPlaces > 6) {
            throw new InvalidArgumentException('Provider connection decimal places are invalid.');
        }
    }
}
