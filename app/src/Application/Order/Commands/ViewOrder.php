<?php

declare(strict_types=1);

namespace Application\Order\Commands;

use Domain\Order\Order;

final readonly class ViewOrder
{
    public function __construct(private Order $order)
    {
    }

    public function order(): Order
    {
        return $this->order;
    }
}
