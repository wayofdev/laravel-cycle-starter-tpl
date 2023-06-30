<?php

declare(strict_types=1);

namespace Laravel\Public\Spec;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'WOD Customers Ecommerce API',
    title: 'WOD Customers API',
    contact: new OA\Contact(
        name: 'John Doe',
        email: 'support@wayof.dev'
    )
)]
class OpenApi
{
}
