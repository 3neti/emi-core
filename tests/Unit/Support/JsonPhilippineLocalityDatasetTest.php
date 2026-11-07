<?php

use LBHurtado\EmiCore\Services\JsonPhilippineLocalityDataset;

it('reads only valid localities and resolves city names without recursively retrying', function (): void {
    $path = tempnam(sys_get_temp_dir(), 'localities-');
    file_put_contents($path, json_encode([
        ['address1' => 'Barangay A', 'city' => 'Manila', 'region' => 'NCR', 'postal_code' => '1000'],
        ['address1' => 'Barangay B', 'city' => 'Cebu City', 'region' => 'Central Visayas', 'postal_code' => '6000'],
        ['address1' => '', 'city' => 'Manila', 'postal_code' => '1000'],
        ['address1' => 'Bad ZIP', 'city' => 'Manila', 'postal_code' => 'nope'],
    ], JSON_THROW_ON_ERROR));
    try {
        $dataset = new JsonPhilippineLocalityDataset($path);
        expect($dataset->candidates())->toHaveCount(2)
            ->and($dataset->candidates('manila', 'NCR'))->toHaveCount(1)
            ->and($dataset->candidates('Manila', 'wrong region'))->toBe([])
            ->and($dataset->version())->toBe('sha256:'.hash_file('sha256', $path));
        $version = $dataset->version();
        file_put_contents($path, '[]');
        expect($dataset->version())->toBe($version)->and($dataset->candidates())->toHaveCount(2);
    } finally {
        unlink($path);
    }
});

it('fails predictably for a missing or malformed locality dataset', function (): void {
    $path = tempnam(sys_get_temp_dir(), 'localities-');
    file_put_contents($path, '{bad');
    try {
        expect(fn () => (new JsonPhilippineLocalityDataset($path))->candidates())->toThrow(RuntimeException::class)
            ->and(fn () => (new JsonPhilippineLocalityDataset($path.'-missing'))->candidates())->toThrow(RuntimeException::class);
    } finally {
        unlink($path);
    }
});

it('does not select a locality for an ambiguous city without a region', function (): void {
    $path = tempnam(sys_get_temp_dir(), 'localities-');
    file_put_contents($path, json_encode([
        ['address1' => 'Barangay A', 'city' => 'San Jose', 'region' => 'Region A', 'postal_code' => '1000'],
        ['address1' => 'Barangay B', 'city' => 'San Jose', 'region' => 'Region B', 'postal_code' => '2000'],
    ], JSON_THROW_ON_ERROR));
    try {
        $dataset = new JsonPhilippineLocalityDataset($path);
        expect($dataset->candidates('San Jose'))->toBe([])
            ->and($dataset->candidates('San Jose', 'Region A'))->toHaveCount(1)
            ->and($dataset->candidates())->toHaveCount(2);
    } finally {
        unlink($path);
    }
});

it('excludes barangays with conflicting postal codes from synthetic candidates', function (): void {
    $path = tempnam(sys_get_temp_dir(), 'localities-');
    file_put_contents($path, json_encode([
        ['address1' => 'Barangay One', 'city' => 'Manila', 'region' => 'NCR', 'postal_code' => '1000'],
        ['address1' => 'barangay one', 'city' => 'manila', 'region' => 'NCR', 'postal_code' => '1001'],
        ['address1' => 'Barangay Two', 'city' => 'Manila', 'region' => 'NCR', 'postal_code' => '1002'],
    ], JSON_THROW_ON_ERROR));
    try {
        $candidates = (new JsonPhilippineLocalityDataset($path))->candidates('Manila', 'NCR');
        expect($candidates)->toHaveCount(1)->and($candidates[0]->postal_code)->toBe('1002');
    } finally {
        unlink($path);
    }
});
