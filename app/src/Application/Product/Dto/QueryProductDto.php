<?php

declare(strict_types=1);

namespace Application\Product\Dto;

use WayOfDev\RQL\Concerns\HasFilters;
use WayOfDev\RQL\Contracts\CriteriaParameters;
use WayOfDev\RQL\Requests\RequestParameter;

final class QueryProductDto implements CriteriaParameters
{
    use HasFilters;

    public ?RequestParameter $id = null;

    public ?RequestParameter $name = null;
}
