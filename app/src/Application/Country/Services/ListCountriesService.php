<?php

declare(strict_types=1);

namespace Application\Country\Services;

use Application\Country\Commands\ListCountries;
use Application\Country\Dto\CountryAssembler;
use Application\Country\Dto\ViewCountryDto;
use Domain\Country\CountryRepository;
use Illuminate\Support\Collection;
use WayOfDev\RQL\Bridge\Cycle\Criteria\FilterBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\LimitBy;
use WayOfDev\RQL\Bridge\Cycle\Criteria\OrderBy;

final readonly class ListCountriesService
{
    public function __construct(
        private CountryRepository $countries,
        private CountryAssembler $assembler
    ) {
    }

    public function handle(ListCountries $command): Collection
    {
        $criteria = $command->criteria();

        $this->countries->pushCriteria(new FilterBy($criteria->parameters()));
        $this->countries->pushCriteria(new LimitBy($criteria->limit()));
        $this->countries->pushCriteria(new OrderBy($criteria->orderBy()));

        /** @var Collection $collection */
        $collection = $this->countries->findAll();

        $collection->transform(function ($item): ViewCountryDto {
            return $this->assembler->toViewCountryDto($item);
        });

        return $collection;
    }
}
