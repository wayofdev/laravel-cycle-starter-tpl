<?php

declare(strict_types=1);

namespace Domain\Category;

use Cycle\ORM\RepositoryInterface;
use Domain\Category\Contracts\CategoryIdGenerator;
use WayOfDev\Paginator\PaginationManager;
use WayOfDev\RQL\Bridge\Cycle\CriteriaManager;

interface CategoryRepository extends RepositoryInterface, CriteriaManager, PaginationManager, CategoryIdGenerator
{
    public function findById(string $id): ?object;
}
