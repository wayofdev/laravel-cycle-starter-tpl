<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Cycle;

use Assert\AssertionFailedException;
use Domain\Client\AddressId;
use Domain\Client\AddressRepository;
use WayOfDev\RQL\Bridge\Cycle\Repository;

final class ORMAddressRepository extends Repository implements AddressRepository
{
    /**
     * @throws AssertionFailedException
     */
    public function nextId(): AddressId
    {
        return AddressId::create();
    }

    public function findById(string $id): ?object
    {
        return $this->findOne(['id' => $id]);
    }
}
