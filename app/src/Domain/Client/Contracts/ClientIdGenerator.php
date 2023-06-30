<?php

declare(strict_types=1);

namespace Domain\Client\Contracts;

use Domain\Client\ClientId;

interface ClientIdGenerator
{
    public function nextId(): ClientId;
}
