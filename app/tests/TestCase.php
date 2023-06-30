<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use WayOfDev\Cycle\Testing\Concerns\InteractsWithDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('cycle:migrate:init');
        Artisan::call('cycle:migrate');
    }
}
