<?php

use LBHurtado\EmiCore\Contracts\PhilippineLocalityDataset;
use LBHurtado\EmiCore\Data\PayoutAddressData;
use LBHurtado\EmiCore\Data\PayoutPartyData;
use LBHurtado\EmiCore\Data\PayoutRequestData;
use LBHurtado\EmiCore\Services\PayoutLocalityResolver;

function localityDataset(): PhilippineLocalityDataset
{
    return new class implements PhilippineLocalityDataset
    {
        public function version(): string
        {
            return 'fixture-v1';
        }

        public function candidates(?string $city = null, ?string $region = null): array
        {
            $all = [
                new PayoutAddressData('Barangay One', 'Manila', 'PH', '1000', 'dataset', 'fixture-v1'),
                new PayoutAddressData('Barangay Two', 'Cebu City', 'PH', '6000', 'dataset', 'fixture-v1'),
            ];

            return array_values(array_filter($all, fn ($entry) => $city === null || strcasecmp($entry->city, $city) === 0));
        }
    };
}

it('preserves legacy payout requests while carrying typed parties when supplied', function (): void {
    $legacy = new PayoutRequestData('ref', 100, '09170000000', 'GXCHPHM2XXX', 'INSTAPAY');
    $address = new PayoutAddressData('Barangay One', 'Manila', 'PH', '1000', 'user_supplied');
    $party = new PayoutPartyData('recipient', 'Recipient', $address);
    $request = new PayoutRequestData('ref', 100, '09170000000', 'GXCHPHM2XXX', 'INSTAPAY', recipient: $party);

    expect($legacy->recipient)->toBeNull()
        ->and($request->recipient->address->source)->toBe('user_supplied')
        ->and($request->toArray()['recipient']['address']['city'])->toBe('Manila')
        ->and($request->toAuditArray())->not->toHaveKey('sender')->not->toHaveKey('recipient');
});

it('resolves supplied, captured, IP-assisted, and synthetic locality in order', function (): void {
    $resolver = new PayoutLocalityResolver(localityDataset(), fn (int $count): int => 0);
    $supplied = new PayoutAddressData('Home', 'Manila', 'PH', '1000', 'user_supplied');
    $captured = new PayoutAddressData('Nearby', 'Cebu City', 'PH', '6000', 'location');

    expect($resolver->resolve($supplied, $captured, 'Cebu City')->source)->toBe('user_supplied')
        ->and($resolver->resolve(null, $captured, 'Manila')->source)->toBe('location')
        ->and($resolver->resolve(null, null, 'Cebu City')->source)->toBe('ip_assisted_synthetic')
        ->and($resolver->resolve(null, null, 'Cebu City')->city)->toBe('Cebu City')
        ->and($resolver->resolve(null, null, 'Unknown')->source)->toBe('synthetic')
        ->and($resolver->resolve(null, null)->dataset_version)->toBe('fixture-v1');
});

it('does not use foreign captured location and fails clearly for an empty dataset', function (): void {
    $resolver = new PayoutLocalityResolver(localityDataset(), fn (int $count): int => 0);
    $foreign = new PayoutAddressData('Elsewhere', 'London', 'GB', 'SW1', 'location');
    expect($resolver->resolve(null, $foreign)->source)->toBe('synthetic');
    $empty = new class implements PhilippineLocalityDataset
    {
        public function version(): string
        {
            return 'empty';
        }

        public function candidates(?string $city = null, ?string $region = null): array
        {
            return [];
        }
    };
    expect(fn () => (new PayoutLocalityResolver($empty))->resolve())->toThrow(RuntimeException::class);
});

it('falls back to a synthetic candidate when an IP-assisted lookup fails', function (): void {
    $dataset = new class implements PhilippineLocalityDataset
    {
        public function version(): string
        {
            return 'fixture-v1';
        }

        public function candidates(?string $city = null, ?string $region = null): array
        {
            if ($city !== null) {
                throw new RuntimeException('Lookup unavailable');
            }

            return [new PayoutAddressData('Barangay One', 'Manila', 'PH', '1000', 'dataset')];
        }
    };

    $result = (new PayoutLocalityResolver($dataset, fn (int $count): int => 0))->resolve(ipCity: 'Manila');
    expect($result->source)->toBe('synthetic')->and($result->city)->toBe('Manila');
});
