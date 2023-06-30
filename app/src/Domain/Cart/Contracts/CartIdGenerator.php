<?php

declare(strict_types=1);

namespace Domain\Cart\Contracts;

use Domain\Cart\CartId;

interface CartIdGenerator
{
    public function nextId(): CartId;
}
