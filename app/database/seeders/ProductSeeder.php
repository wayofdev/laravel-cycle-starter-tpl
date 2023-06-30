<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\Domain\ProductFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Throwable;

final class ProductSeeder extends Seeder
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function run(): void
    {
        ProductFactory::new()->times(10)->create();
    }
}
