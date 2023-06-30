<?php

declare(strict_types=1);

namespace Laravel;

use Auth0\Laravel\Middleware\AuthorizerMiddleware;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Http\Middleware\AcceptsJson;
use Laravel\Http\Middleware\SupportsPagination;

final class HttpKernel extends Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        AcceptsJson::class,
        SupportsPagination::class,
        \Laravel\Http\Middleware\TrustHosts::class,
        \Laravel\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Laravel\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Laravel\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api-public' => [
            // ThrottleRequests::class . ':api',
            AuthorizerMiddleware::class,
            AcceptsJson::class,
            SubstituteBindings::class,
        ],

        'api-private' => [
            // ThrottleRequests::class . ':api',
            AuthorizerMiddleware::class,
            AcceptsJson::class,
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \Laravel\Http\Middleware\Authenticate::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Laravel\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Laravel\Http\Middleware\ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
    ];
}
