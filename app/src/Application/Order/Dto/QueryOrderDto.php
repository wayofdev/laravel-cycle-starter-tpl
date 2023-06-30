<?php

declare(strict_types=1);

namespace Application\Order\Dto;

use WayOfDev\RQL\Concerns\HasFilters;
use WayOfDev\RQL\Contracts\CriteriaParameters;
use WayOfDev\RQL\Requests\RequestParameter;

final class QueryOrderDto implements CriteriaParameters
{
    use HasFilters;

    public ?RequestParameter $id = null;
}
