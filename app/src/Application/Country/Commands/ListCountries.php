<?php

declare(strict_types=1);

namespace Application\Country\Commands;

use Application\Country\Dto\QueryCountryDto;
use WayOfDev\RQL\CriteriaAggregate;

final readonly class ListCountries
{
    public function __construct(private QueryCountryDto $query)
    {
    }

    public function criteria(): CriteriaAggregate
    {
        return new CriteriaAggregate($this->query);
    }
}
