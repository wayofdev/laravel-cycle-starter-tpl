<?php

declare(strict_types=1);

namespace Database\Factories\Domain;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Order\Contracts\OrderIdGenerator;
use Domain\Order\Order;
use WayOfDev\DatabaseSeeder\Factories\AbstractFactory;

class OrderFactory extends AbstractFactory
{
    /**
     * @throws AssertionFailedException
     */
    public function definition(): array
    {
        /** @var OrderIdGenerator $generator */
        $generator = app(OrderIdGenerator::class);

        return [
            'id' => $generator->nextId(),
            'signature' => Signature::random(),
        ];
    }

    public function makeEntity(array $definition): Order
    {
        return new Order(
            id: $definition['id'],
            signature: $definition['signature'],
        );
    }

    public function entity(): string
    {
        return Order::class;
    }
}
