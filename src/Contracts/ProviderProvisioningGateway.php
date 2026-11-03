<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

interface ProviderProvisioningGateway
{
    public function providerCode(): string;

    public function supports(string $provider, string $mode): bool;

    /** @param array<string, mixed> $payload @return array<string, mixed> */
    public function provision(mixed $owner, array $payload): array;

    /** @return array<string, mixed> */
    public function refresh(mixed $link): array;
}
