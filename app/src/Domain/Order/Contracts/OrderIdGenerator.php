<?php

declare(strict_types=1);

namespace Domain\Order\Contracts;

use Domain\Order\OrderId;

interface OrderIdGenerator
{
    public function nextId(): OrderId;
}
