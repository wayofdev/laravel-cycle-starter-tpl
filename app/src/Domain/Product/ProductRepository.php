<?php

declare(strict_types=1);

namespace Domain\Product;

use Cycle\ORM\RepositoryInterface;
use Domain\Product\Contracts\ProductIdGenerator;
use WayOfDev\Paginator\PaginationManager;
use WayOfDev\RQL\Bridge\Cycle\CriteriaManager;

interface ProductRepository extends RepositoryInterface, CriteriaManager, PaginationManager, ProductIdGenerator
{
    public function findById(string $id): ?object;
}
