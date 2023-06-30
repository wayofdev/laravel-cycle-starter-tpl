<?php

declare(strict_types=1);

namespace Laravel\Providers\Domain;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use Domain\Order\Contracts\OrderIdGenerator;
use Domain\Order\Exceptions\OrderNotFoundException;
use Domain\Order\Order;
use Domain\Order\OrderRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Persistence\Cycle\ORMOrderRepository;

final class OrderServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->bindOrderEntity();
    }

    public function register(): void
    {
        $this->app->bind(
            OrderRepository::class,
            ORMOrderRepository::class
        );

        $this->app->when(ORMOrderRepository::class)
            ->needs(Select::class)
            ->give(function (): Select {
                return new Select($this->app->make(ORMInterface::class), 'order');
            });

        $this->app->bind(OrderIdGenerator::class, OrderRepository::class);
    }

    /**
     * @throws BindingResolutionException
     */
    private function bindOrderEntity(): void
    {
        $repository = $this->app->make(OrderRepository::class);

        Route::bind('order', static function ($value) use ($repository) {
            /** @var Order|null $order */
            $order = $repository->findById($value);

            if (null === $order) {
                throw new OrderNotFoundException();
            }

            return $order;
        });
    }
}
