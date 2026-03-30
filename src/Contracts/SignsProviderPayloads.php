<?php

namespace LBHurtado\EmiCore\Contracts;

interface SignsProviderPayloads
{
    /**
     * @param  array<string, mixed>  $fields
     */
    public function generateSignature(array $fields, string $integrationKey): string;
}
