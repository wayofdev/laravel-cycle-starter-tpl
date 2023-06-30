<?php

declare(strict_types=1);

namespace Application\Product\Commands;

use Application\Product\Dto\QueryProductDto;
use WayOfDev\RQL\CriteriaAggregate;

final readonly class ListProducts
{
    public function __construct(private QueryProductDto $query)
    {
    }

    public function criteria(): CriteriaAggregate
    {
        return new CriteriaAggregate($this->query);
    }
}
