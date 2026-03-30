<?php

namespace LBHurtado\EmiCore\Contracts;

interface VerifiesProviderPostbacks
{
    /**
     * @param  array<string, mixed>  $payload
     */
    public function verifySignature(array $payload, string $integrationKey): bool;
}
