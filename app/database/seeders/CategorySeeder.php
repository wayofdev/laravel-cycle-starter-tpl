<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\Domain\CategoryFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Throwable;

final class CategorySeeder extends Seeder
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function run(): void
    {
        CategoryFactory::new()->times(10)->create();
    }
}
