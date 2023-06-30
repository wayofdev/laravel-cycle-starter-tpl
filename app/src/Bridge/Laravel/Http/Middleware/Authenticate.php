<?php

declare(strict_types=1);

namespace Laravel\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

final class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards): void
    {
        abort(401);
    }
}
