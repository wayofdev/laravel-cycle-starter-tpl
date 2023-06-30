<?php

declare(strict_types=1);

namespace Domain\Cart;

use Cycle\ORM\RepositoryInterface;
use Domain\Cart\Contracts\CartIdGenerator;
use WayOfDev\Paginator\PaginationManager;
use WayOfDev\RQL\Bridge\Cycle\CriteriaManager;

interface CartRepository extends RepositoryInterface, CriteriaManager, PaginationManager, CartIdGenerator
{
    public function findById(string $id): ?object;
}
