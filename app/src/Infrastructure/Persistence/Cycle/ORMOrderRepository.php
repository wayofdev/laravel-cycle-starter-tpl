<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Cycle;

use Assert\AssertionFailedException;
use Domain\Order\OrderId;
use Domain\Order\OrderRepository;
use WayOfDev\RQL\Bridge\Cycle\Repository;

final class ORMOrderRepository extends Repository implements OrderRepository
{
    /**
     * @throws AssertionFailedException
     */
    public function nextId(): OrderId
    {
        return OrderId::create();
    }

    public function findById(string $id): ?object
    {
        return $this->findOne(['id' => $id]);
    }
}
