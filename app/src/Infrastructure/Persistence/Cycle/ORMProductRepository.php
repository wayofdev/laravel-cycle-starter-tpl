<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Cycle;

use Assert\AssertionFailedException;
use Domain\Product\ProductId;
use Domain\Product\ProductRepository;
use WayOfDev\RQL\Bridge\Cycle\Repository;

final class ORMProductRepository extends Repository implements ProductRepository
{
    /**
     * @throws AssertionFailedException
     */
    public function nextId(): ProductId
    {
        return ProductId::create();
    }

    public function findById(string $id): ?object
    {
        return $this->findOne(['id' => $id]);
    }
}
