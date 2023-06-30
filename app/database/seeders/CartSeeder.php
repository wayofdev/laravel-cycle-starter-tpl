<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\Domain\CartFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Throwable;

final class CartSeeder extends Seeder
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function run(): void
    {
        CartFactory::new()->times(10)->create();
    }
}
