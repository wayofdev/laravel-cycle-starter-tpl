<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\Domain\ClientFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Throwable;

final class ClientSeeder extends Seeder
{
    /**
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function run(): void
    {
        ClientFactory::new()->times(10)->create();
    }
}
