<?php

declare(strict_types=1);

namespace Domain\Order;

use Cycle\ORM\RepositoryInterface;
use Domain\Order\Contracts\OrderIdGenerator;
use WayOfDev\Paginator\PaginationManager;
use WayOfDev\RQL\Bridge\Cycle\CriteriaManager;

interface OrderRepository extends RepositoryInterface, CriteriaManager, PaginationManager, OrderIdGenerator
{
    public function findById(string $id): ?object;
}
