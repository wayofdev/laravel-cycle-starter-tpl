<?php

declare(strict_types=1);

namespace Domain\Order\Contracts;

use Domain\Order\Factories\OrderInput;
use Domain\Order\Order;

interface OrderFactory
{
    public function create(OrderInput $input): Order;
}
