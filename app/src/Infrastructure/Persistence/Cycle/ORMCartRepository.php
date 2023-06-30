<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Cycle;

use Assert\AssertionFailedException;
use Domain\Cart\CartId;
use Domain\Cart\CartRepository;
use WayOfDev\RQL\Bridge\Cycle\Repository;

final class ORMCartRepository extends Repository implements CartRepository
{
    /**
     * @throws AssertionFailedException
     */
    public function nextId(): CartId
    {
        return CartId::create();
    }

    public function findById(string $id): ?object
    {
        return $this->findOne(['id' => $id]);
    }
}
