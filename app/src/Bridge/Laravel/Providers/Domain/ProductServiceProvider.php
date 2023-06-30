<?php

declare(strict_types=1);

namespace Laravel\Providers\Domain;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use Domain\Product\Contracts\ProductIdGenerator;
use Domain\Product\Exceptions\ProductNotFoundException;
use Domain\Product\Product;
use Domain\Product\ProductRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Persistence\Cycle\ORMProductRepository;

final class ProductServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bindProductEntity();
    }

    public function register(): void
    {
        $this->app->bind(
            ProductRepository::class,
            ORMProductRepository::class
        );

        $this->app->when(ORMProductRepository::class)
            ->needs(Select::class)
            ->give(function (): Select {
                return new Select($this->app->make(ORMInterface::class), 'product');
            });

        $this->app->bind(ProductIdGenerator::class, ProductRepository::class);
    }

    /**
     * @throws BindingResolutionException
     */
    private function bindProductEntity(): void
    {
        $repository = $this->app->make(ProductRepository::class);

        Route::bind('product', static function ($value) use ($repository) {
            /** @var Product|null $product */
            $product = $repository->findById($value);

            if (null === $product) {
                throw new ProductNotFoundException();
            }

            return $product;
        });
    }
}
