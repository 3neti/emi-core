<?php

namespace LBHurtado\EmiCore\Data;

use Spatie\LaravelData\Data;

class SystemReadinessResult extends Data
{
    public function __construct(
        public bool $ready,
        /** @var array<int, string> */
        public array $issues = [],
    ) {}

    public static function ok(): self
    {
        return new self(ready: true);
    }

    public static function fail(string ...$issues): self
    {
        return new self(ready: false, issues: array_values($issues));
    }
}
