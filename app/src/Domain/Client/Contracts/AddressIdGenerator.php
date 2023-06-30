<?php

declare(strict_types=1);

namespace Domain\Client\Contracts;

use Domain\Client\AddressId;

interface AddressIdGenerator
{
    public function nextId(): AddressId;
}
