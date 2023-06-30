<?php

declare(strict_types=1);

namespace Laravel\Http\Middleware;

use Closure;
use Domain\Shared\Api\Pagination\Pagination;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

final class SupportsPagination
{
    private Application $app;

    private Config $config;

    public function __construct(Application $app, Config $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        $defaultPage = $this->config->get('pagination.page', 1);
        $defaultPerPage = $this->config->get('pagination.per_page', 20);

        $this->app->singleton(Pagination::class, static function () use ($request, $defaultPage, $defaultPerPage): Pagination {
            return new Pagination(
                (int) $request->get('page', $defaultPage),
                (int) $request->get('per_page', $defaultPerPage)
            );
        });

        return $next($request);
    }
}
