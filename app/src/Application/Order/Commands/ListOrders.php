<?php

declare(strict_types=1);

namespace Application\Order\Commands;

use Application\Order\Dto\QueryOrderDto;
use WayOfDev\RQL\CriteriaAggregate;

final readonly class ListOrders
{
    public function __construct(private QueryOrderDto $query)
    {
    }

    public function criteria(): CriteriaAggregate
    {
        return new CriteriaAggregate($this->query);
    }
}
