<?php

declare(strict_types=1);

namespace Domain\Client;

use Cycle\ORM\RepositoryInterface;
use Domain\Client\Contracts\AddressIdGenerator;
use WayOfDev\Paginator\PaginationManager;
use WayOfDev\RQL\Bridge\Cycle\CriteriaManager;

interface AddressRepository extends RepositoryInterface, CriteriaManager, PaginationManager, AddressIdGenerator
{
    public function findById(string $id): ?object;
}
