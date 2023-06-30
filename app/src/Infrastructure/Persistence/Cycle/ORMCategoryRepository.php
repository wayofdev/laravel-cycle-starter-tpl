<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Cycle;

use Assert\AssertionFailedException;
use Domain\Category\CategoryId;
use Domain\Category\CategoryRepository;
use WayOfDev\RQL\Bridge\Cycle\Repository;

final class ORMCategoryRepository extends Repository implements CategoryRepository
{
    /**
     * @throws AssertionFailedException
     */
    public function nextId(): CategoryId
    {
        return CategoryId::create();
    }

    public function findById(string $id): ?object
    {
        return $this->findOne(['id' => $id]);
    }
}
