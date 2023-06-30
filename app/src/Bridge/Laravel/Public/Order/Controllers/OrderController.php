<?php

declare(strict_types=1);

namespace Laravel\Public\Order\Controllers;

use Laravel\Http\ApiController;
use Spatie\RouteAttributes\Attributes\ApiResource;

#[ApiResource(
    resource: 'orders',
    only: ['index', 'show'],
    names: 'api.public.orders',
    shallow: true,
)]
class OrderController extends ApiController
{
}
