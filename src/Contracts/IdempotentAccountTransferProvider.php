<?php

declare(strict_types=1);

namespace LBHurtado\EmiCore\Contracts;

/** The provider honors identical retries under the frozen idempotency key. */
interface IdempotentAccountTransferProvider extends AccountTransferProvider {}
