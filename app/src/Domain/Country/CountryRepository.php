<?php

declare(strict_types=1);

namespace Domain\Country;

use Cycle\ORM\RepositoryInterface;
use WayOfDev\Paginator\PaginationManager;
use WayOfDev\RQL\Bridge\Cycle\CriteriaManager;

interface CountryRepository extends RepositoryInterface, CriteriaManager, PaginationManager
{
    public function findById(string $id): ?object;
}
