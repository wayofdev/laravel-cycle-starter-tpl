<?php

declare(strict_types=1);

namespace Domain\User;

use Cycle\ORM\RepositoryInterface;

interface UserRepository extends RepositoryInterface
{
    public function findById(string $id): ?object;
}
