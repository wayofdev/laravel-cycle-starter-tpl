<?php

declare(strict_types=1);

namespace Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Clock::class, static function (): SystemClock {
            return SystemClock::fromSystemTimezone();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
