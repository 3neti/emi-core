<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Data\Configuration;

use InvalidArgumentException;

final readonly class EnvironmentVariableData
{
    /**
     * @param  list<string>  $requiredForProfiles
     * @param  list<string>  $requiredForProviders
     */
    public function __construct(
        public string $key,
        public string $description,
        public string $category,
        public ?string $safeExample = null,
        public bool $secret = false,
        public bool $required = false,
        public array $requiredForProfiles = [],
        public array $requiredForProviders = [],
    ) {
        if (preg_match('/^[A-Z][A-Z0-9_]*$/', $this->key) !== 1) {
            throw new InvalidArgumentException("Environment key [{$this->key}] is invalid.");
        }

        if (trim($this->description) === '' || trim($this->category) === '') {
            throw new InvalidArgumentException(
                "Environment descriptor [{$this->key}] requires a description and category.",
            );
        }

        if ($this->secret && $this->safeExample !== null && $this->safeExample !== '') {
            throw new InvalidArgumentException(
                "Secret environment descriptor [{$this->key}] cannot contain an example value.",
            );
        }
    }

    /**
     * @param  list<string>  $providerCodes
     */
    public function isRequired(string $profile, array $providerCodes): bool
    {
        if ($this->required) {
            return true;
        }

        if (in_array($profile, $this->requiredForProfiles, true)) {
            return true;
        }

        return array_intersect($providerCodes, $this->requiredForProviders) !== [];
    }
}
