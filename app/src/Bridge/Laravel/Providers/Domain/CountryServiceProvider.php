<?php

declare(strict_types=1);

namespace Laravel\Providers\Domain;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use Domain\Country\Country;
use Domain\Country\CountryRepository;
use Domain\Country\Exceptions\CountryNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Persistence\Cycle\ORMCountryRepository;

final class CountryServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bindCountryEntity();
    }

    public function register(): void
    {
        $this->app->bind(
            CountryRepository::class,
            ORMCountryRepository::class
        );

        $this->app->when(ORMCountryRepository::class)
            ->needs(Select::class)
            ->give(function (): Select {
                return new Select($this->app->make(ORMInterface::class), 'country');
            });
    }

    /**
     * @throws BindingResolutionException
     */
    private function bindCountryEntity(): void
    {
        $repository = $this->app->make(CountryRepository::class);

        Route::bind('country', static function ($value) use ($repository) {
            /** @var Country|null $country */
            $country = $repository->findById($value);

            if (null === $country) {
                throw new CountryNotFoundException();
            }

            return $country;
        });
    }
}
