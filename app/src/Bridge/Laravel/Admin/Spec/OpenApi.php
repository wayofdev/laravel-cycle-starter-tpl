<?php

declare(strict_types=1);

namespace Laravel\Admin\Spec;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'WOD Operations Ecommerce API',
    title: 'WOD Operations API',
    contact: new OA\Contact(
        name: 'John Doe',
        email: 'support@wayof.dev'
    )
)]
class OpenApi
{
}
