<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\Domain\AddressFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Throwable;

final class AddressSeeder extends Seeder
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function run(): void
    {
        AddressFactory::new()->times(10)->create();
    }
}
