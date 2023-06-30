<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\Domain\OrderFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Throwable;

final class OrderSeeder extends Seeder
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function run(): void
    {
        OrderFactory::new()->times(10)->create();
    }
}
