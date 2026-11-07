<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Services;

use Closure;
use LBHurtado\EmiCore\Contracts\PhilippineLocalityDataset;
use LBHurtado\EmiCore\Data\PayoutAddressData;
use RuntimeException;
use Throwable;

final readonly class PayoutLocalityResolver
{
    private Closure $choose;

    public function __construct(private PhilippineLocalityDataset $dataset, ?Closure $choose = null)
    {
        $this->choose = $choose ?? static fn (int $count): int => random_int(0, $count - 1);
    }

    public function resolve(?PayoutAddressData $supplied = null, ?PayoutAddressData $captured = null, ?string $ipCity = null, ?string $ipRegion = null): PayoutAddressData
    {
        if ($supplied !== null) {
            return $supplied;
        }
        if ($captured !== null && strtoupper($captured->country) === 'PH' && trim($captured->city) !== '' && trim($captured->address1) !== '' && trim($captured->postal_code) !== '') {
            return $captured;
        }

        $candidates = [];
        if ($ipCity !== null && trim($ipCity) !== '') {
            try {
                $candidates = $this->dataset->candidates($ipCity, $ipRegion);
            } catch (Throwable) {
                $candidates = [];
            }
        }
        $source = $candidates !== [] ? 'ip_assisted_synthetic' : 'synthetic';
        if ($candidates === []) {
            $candidates = $this->dataset->candidates();
        }
        if ($candidates === []) {
            throw new RuntimeException('No Philippine locality candidates are available.');
        }
        $index = ($this->choose)(count($candidates));
        if (! isset($candidates[$index])) {
            throw new RuntimeException('Locality selection returned an invalid index.');
        }
        $selected = $candidates[$index];

        return new PayoutAddressData($selected->address1, $selected->city, $selected->country, $selected->postal_code, $source, $this->dataset->version());
    }
}
