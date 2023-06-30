<?php

declare(strict_types=1);

namespace Laravel\Providers\Domain;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use Domain\Client\AddressRepository;
use Domain\Client\Client;
use Domain\Client\ClientRepository;
use Domain\Client\Contracts\AddressIdGenerator;
use Domain\Client\Contracts\ClientIdGenerator;
use Domain\Client\Exceptions\ClientNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Persistence\Cycle\ORMAddressRepository;
use Infrastructure\Persistence\Cycle\ORMClientRepository;

final class ClientServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bindClientEntity();
    }

    public function register(): void
    {
        $this->registerClientRepository();
        $this->registerAddressRepository();
    }

    private function registerClientRepository(): void
    {
        $this->app->bind(
            ClientRepository::class,
            ORMClientRepository::class
        );

        $this->app->when(ORMClientRepository::class)
            ->needs(Select::class)
            ->give(function (): Select {
                return new Select($this->app->make(ORMInterface::class), 'client');
            });

        $this->app->bind(ClientIdGenerator::class, ClientRepository::class);
    }

    private function registerAddressRepository(): void
    {
        $this->app->bind(
            AddressRepository::class,
            ORMAddressRepository::class
        );

        $this->app->when(ORMAddressRepository::class)
            ->needs(Select::class)
            ->give(function (): Select {
                return new Select($this->app->make(ORMInterface::class), 'client');
            });

        $this->app->bind(AddressIdGenerator::class, AddressRepository::class);
    }

    /**
     * @throws BindingResolutionException
     */
    private function bindClientEntity(): void
    {
        $repository = $this->app->make(ClientRepository::class);

        Route::bind('client', static function ($value) use ($repository) {
            /** @var Client|null $client */
            $client = $repository->findById($value);

            if (null === $client) {
                throw new ClientNotFoundException();
            }

            return $client;
        });
    }
}
