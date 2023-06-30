<?php

declare(strict_types=1);

namespace Laravel\Providers\Domain;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use Domain\Cart\Cart;
use Domain\Cart\CartRepository;
use Domain\Cart\Contracts\CartIdGenerator;
use Domain\Cart\Exceptions\CartNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Persistence\Cycle\ORMCartRepository;

final class CartServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bindCartEntity();
    }

    public function register(): void
    {
        $this->app->bind(
            CartRepository::class,
            ORMCartRepository::class
        );

        $this->app->when(ORMCartRepository::class)
            ->needs(Select::class)
            ->give(function (): Select {
                return new Select($this->app->make(ORMInterface::class), 'cart');
            });

        $this->app->bind(CartIdGenerator::class, CartRepository::class);
    }

    /**
     * @throws BindingResolutionException
     */
    private function bindCartEntity(): void
    {
        $repository = $this->app->make(CartRepository::class);

        Route::bind('cart', static function ($value) use ($repository) {
            /** @var Cart|null $cart */
            $cart = $repository->findById($value);

            if (null === $cart) {
                throw new CartNotFoundException();
            }

            return $cart;
        });
    }
}
