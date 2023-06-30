<?php

declare(strict_types=1);

namespace Database\Factories\Domain;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Client\Client;
use Domain\Client\Contracts\ClientIdGenerator;
use Domain\Client\Name;
use Domain\Client\PersonalInfo;
use Domain\Shared\Gender;
use WayOfDev\DatabaseSeeder\Factories\AbstractFactory;

class ClientFactory extends AbstractFactory
{
    protected string $entity = Client::class;

    /**
     * @throws AssertionFailedException
     */
    public function definition(): array
    {
        /** @var ClientIdGenerator $generator */
        $generator = app(ClientIdGenerator::class);

        return [
            'id' => $generator->nextId(),
            'userId' => null,
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'name' => Name::fromArray([
                'firstName' => fake()->firstName(),
                'lastName' => fake()->lastName(),
                'middleName' => fake()->lastName(),
            ]),
            'personalInfo' => PersonalInfo::fromArray([
                'gender' => $this->faker->randomElement(Gender::cases())->toString(),
                'birthDate' => null,
            ]),
            'company' => fake()->company(),
            'signature' => Signature::random(),
        ];
    }

    /**
     * @throws AssertionFailedException
     */
    public function deleted(): ClientFactory
    {
        $deleted = Signature::random();

        return $this->state(fn (array $attributes) => [
            'deleted' => $deleted,
        ]);
    }

    public function makeEntity(array $definition): Client
    {
        return new Client(
            id: $definition['id'],
            userId: $definition['userId'],
            email: $definition['email'],
            username: $definition['username'],
            name: $definition['name'],
            personalInfo: $definition['personalInfo'],
            company: $definition['company'],
            signature: $definition['signature'],
        );
    }

    public function entity(): string
    {
        return Client::class;
    }
}
