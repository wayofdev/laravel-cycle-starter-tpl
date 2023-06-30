<?php

declare(strict_types=1);

namespace Database\Factories\Domain;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Category\Category;
use Domain\Category\Contracts\CategoryIdGenerator;
use Domain\Shared\Gender;
use WayOfDev\DatabaseSeeder\Factories\AbstractFactory;

class CategoryFactory extends AbstractFactory
{
    /**
     * @throws AssertionFailedException
     */
    public function definition(): array
    {
        /** @var CategoryIdGenerator $generator */
        $generator = app(CategoryIdGenerator::class);

        return [
            'id' => $generator->nextId(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(Gender::cases()),
            'signature' => Signature::random(),
        ];
    }

    public function makeEntity(array $definition): Category
    {
        return new Category(
            id: $definition['id'],
            name: $definition['name'],
            gender: $definition['gender'],
            signature: $definition['signature'],
        );
    }

    public function entity(): string
    {
        return Category::class;
    }
}
