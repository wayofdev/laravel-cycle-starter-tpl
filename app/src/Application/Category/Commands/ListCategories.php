<?php

declare(strict_types=1);

namespace Application\Category\Commands;

use Application\Category\Dto\QueryCategoryDto;
use WayOfDev\RQL\CriteriaAggregate;

final readonly class ListCategories
{
    public function __construct(private QueryCategoryDto $query)
    {
    }

    public function criteria(): CriteriaAggregate
    {
        return new CriteriaAggregate($this->query);
    }
}
