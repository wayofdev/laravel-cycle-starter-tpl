<?php

declare(strict_types=1);

namespace Database\Factories\Domain;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Client\Address\Address;
use Domain\Client\Address\Type;
use Domain\Client\Contracts\AddressIdGenerator;
use WayOfDev\DatabaseSeeder\Factories\AbstractFactory;

class AddressFactory extends AbstractFactory
{
    /**
     * @throws AssertionFailedException
     */
    public function definition(): array
    {
        /** @var AddressIdGenerator $generator */
        $generator = app(AddressIdGenerator::class);
        $client = ClientFactory::new()->make();

        return [
            'id' => $generator->nextId(),
            'type' => $this->faker->randomElement(Type::cases()),
            'client' => $client,
            'signature' => Signature::random(),
        ];
    }

    public function makeEntity(array $definition): Address
    {
        return new Address(
            id: $definition['id'],
            type: $definition['type'],
            client: $definition['client'],
            signature: $definition['signature'],
        );
    }

    public function entity(): string
    {
        return Address::class;
    }
}
