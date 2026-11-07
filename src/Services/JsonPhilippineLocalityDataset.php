<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Services;

use JsonException;
use LBHurtado\EmiCore\Contracts\PhilippineLocalityDataset;
use LBHurtado\EmiCore\Data\PayoutAddressData;
use RuntimeException;

final class JsonPhilippineLocalityDataset implements PhilippineLocalityDataset
{
    /** @var list<array{address1: string, city: string, region: ?string, postal_code: string}>|null */
    private ?array $entries = null;

    private ?string $loadedVersion = null;

    public function __construct(private readonly string $path) {}

    public function version(): string
    {
        $this->load();

        return $this->loadedVersion;
    }

    public function candidates(?string $city = null, ?string $region = null): array
    {
        $entries = $this->load();
        $version = $this->version();
        $result = [];
        $matchedRegions = [];
        foreach ($entries as $entry) {
            if ($city !== null && mb_strtolower(trim($city)) !== mb_strtolower($entry['city'])) {
                continue;
            }
            if ($region !== null && mb_strtolower(trim($region)) !== mb_strtolower($entry['region'] ?? '')) {
                continue;
            }
            $matchedRegions[mb_strtolower($entry['region'] ?? '')] = true;
            $result[] = new PayoutAddressData($entry['address1'], $entry['city'], 'PH', $entry['postal_code'], 'dataset', $version);
        }

        if ($city !== null && $region === null && count($matchedRegions) > 1) {
            return [];
        }

        return $result;
    }

    private function load(): array
    {
        if ($this->entries !== null) {
            return $this->entries;
        }
        if (! is_file($this->path) || ! is_readable($this->path)) {
            throw new RuntimeException('Philippine locality dataset is unavailable.');
        }
        try {
            $contents = file_get_contents($this->path);
            if ($contents === false) {
                throw new RuntimeException('Philippine locality dataset is unavailable.');
            }
            $data = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Philippine locality dataset is invalid.', previous: $exception);
        }
        if (! is_array($data) || ! array_is_list($data)) {
            throw new RuntimeException('Philippine locality dataset is invalid.');
        }
        $entries = [];
        foreach ($data as $entry) {
            if (! is_array($entry) || ! is_string($entry['address1'] ?? null) || trim($entry['address1']) === ''
                || ! is_string($entry['city'] ?? null) || trim($entry['city']) === ''
                || ! is_string($entry['postal_code'] ?? null) || ! preg_match('/\A[0-9]{4}\z/', $entry['postal_code'])) {
                continue;
            }
            $entries[] = ['address1' => trim($entry['address1']), 'city' => trim($entry['city']),
                'region' => is_string($entry['region'] ?? null) ? trim($entry['region']) : null,
                'postal_code' => $entry['postal_code']];
        }

        $postalCodes = [];
        foreach ($entries as $entry) {
            $key = mb_strtolower(implode('|', [$entry['region'] ?? '', $entry['city'], $entry['address1']]));
            $postalCodes[$key][$entry['postal_code']] = true;
        }
        $entries = array_values(array_filter($entries, static function (array $entry) use ($postalCodes): bool {
            $key = mb_strtolower(implode('|', [$entry['region'] ?? '', $entry['city'], $entry['address1']]));

            return count($postalCodes[$key]) === 1;
        }));

        $this->loadedVersion = 'sha256:'.hash('sha256', $contents);

        return $this->entries = $entries;
    }
}
