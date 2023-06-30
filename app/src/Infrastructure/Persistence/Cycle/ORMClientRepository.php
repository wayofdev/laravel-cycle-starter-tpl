<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Cycle;

use Assert\AssertionFailedException;
use Domain\Client\ClientId;
use Domain\Client\ClientRepository;
use WayOfDev\RQL\Bridge\Cycle\Repository;

final class ORMClientRepository extends Repository implements ClientRepository
{
    /**
     * @throws AssertionFailedException
     */
    public function nextId(): ClientId
    {
        return ClientId::create();
    }

    public function findById(string $id): ?object
    {
        return $this->findOne(['id' => $id]);
    }
}
