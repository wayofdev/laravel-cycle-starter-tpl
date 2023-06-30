<?php

declare(strict_types=1);

namespace Database\Factories\Domain;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Cart\Cart;
use Domain\Cart\Contracts\CartIdGenerator;
use WayOfDev\DatabaseSeeder\Factories\AbstractFactory;

class CartFactory extends AbstractFactory
{
    /**
     * @throws AssertionFailedException
     */
    public function definition(): array
    {
        /** @var CartIdGenerator $generator */
        $generator = app(CartIdGenerator::class);

        return [
            'id' => $generator->nextId(),
            'signature' => Signature::random(),
        ];
    }

    public function makeEntity(array $definition): Cart
    {
        return new Cart(
            id: $definition['id'],
            signature: $definition['signature'],
        );
    }

    public function entity(): string
    {
        return Cart::class;
    }
}
