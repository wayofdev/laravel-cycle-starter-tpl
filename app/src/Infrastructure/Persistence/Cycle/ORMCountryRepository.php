<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Cycle;

use Domain\Country\CountryRepository;
use WayOfDev\RQL\Bridge\Cycle\Repository;

final class ORMCountryRepository extends Repository implements CountryRepository
{
    public function findById(string $id): ?object
    {
        return $this->findOne(['id' => $id]);
    }
}
