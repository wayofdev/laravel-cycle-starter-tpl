<?php

declare(strict_types=1);

namespace Domain\Role;

use Cycle\ORM\RepositoryInterface;

interface RoleRepository extends RepositoryInterface
{
    public function findById(string $id): ?object;
}
