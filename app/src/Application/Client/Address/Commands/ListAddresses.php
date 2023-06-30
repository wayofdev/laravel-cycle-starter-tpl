<?php

declare(strict_types=1);

namespace Application\Client\Address\Commands;

use Application\Client\Dto\QueryClientDto;
use WayOfDev\RQL\CriteriaAggregate;

final readonly class ListAddresses
{
    public function __construct(private QueryClientDto $query)
    {
    }

    public function criteria(): CriteriaAggregate
    {
        return new CriteriaAggregate($this->query);
    }
}
