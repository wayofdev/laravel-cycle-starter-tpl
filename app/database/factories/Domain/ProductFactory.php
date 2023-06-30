<?php

declare(strict_types=1);

namespace Database\Factories\Domain;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Category\CategoryRepository;
use Domain\Product\Code\Code;
use Domain\Product\Code\Ian;
use Domain\Product\Code\Sku;
use Domain\Product\Code\Upc;
use Domain\Product\Contracts\ProductIdGenerator;
use Domain\Product\Product;
use Domain\Product\Seo;
use Domain\Product\Status;
use Exception;
use WayOfDev\DatabaseSeeder\Factories\AbstractFactory;

class ProductFactory extends AbstractFactory
{
    protected string $entity = Product::class;

    /**
     * @throws AssertionFailedException
     * @throws Exception
     */
    public function definition(): array
    {
        /** @var ProductIdGenerator $generator */
        $generator = app(ProductIdGenerator::class);
        $categories = app(CategoryRepository::class)->findAll();

        return [
            'id' => $generator->nextId(),
            'name' => $this->faker->name(),
            'status' => $this->faker->randomElement(Status::cases()),
            'description' => $this->faker->text(),
            'category' => $this->faker->randomElement($categories),
            'code' => Code::fromArray([
                'sku' => Sku::fromString('S' . $this->faker->numberBetween(1000, 999999))->toString(),
                'ian' => Ian::fromString($this->faker->ean13())->toString(),
                'upc' => Upc::fromString($this->faker->ean13())->toString(),
            ]),
            'seo' => Seo::fromArray([
                'slug' => $this->faker->slug(),
                'title' => $this->faker->name(),
                'description' => $this->faker->text(),
            ]),
            'signature' => Signature::random(),
        ];
    }

    public function makeEntity(array $definition): Product
    {
        return new Product(
            id: $definition['id'],
            name: $definition['name'],
            status: $definition['status'],
            description: $definition['description'],
            category: $definition['category'],
            code: $definition['code'],
            seo: $definition['seo'],
            signature: $definition['signature'],
        );
    }

    public function entity(): string
    {
        return Product::class;
    }
}
