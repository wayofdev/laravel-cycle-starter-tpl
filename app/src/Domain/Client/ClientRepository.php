<?php

declare(strict_types=1);

namespace Domain\Client;

use Cycle\ORM\RepositoryInterface;
use Domain\Client\Contracts\ClientIdGenerator;
use WayOfDev\Paginator\PaginationManager;
use WayOfDev\RQL\Bridge\Cycle\CriteriaManager;

interface ClientRepository extends RepositoryInterface, CriteriaManager, PaginationManager, ClientIdGenerator
{
    public function findById(string $id): ?object;
}
