<?php

declare(strict_types=1);

namespace Domain\Product\Factories;

use Domain\Auth\Signature;
use Domain\Category\Category;
use Domain\Category\CategoryRepository;
use Domain\Product\Contracts\ProductFactory;
use Domain\Product\Contracts\ProductIdGenerator;
use Domain\Product\Product;
use Lcobucci\Clock\Clock;

final readonly class FromRequestProductFactory implements ProductFactory
{
    public function __construct(
        private ProductIdGenerator $generator,
        private CategoryRepository $category,
        private Clock $clock
    ) {
    }

    public function create(ProductInput $input): Product
    {
        $signature = new Signature($this->clock->now(), $input->footprint());

        /** @var Category $category */
        $category = $this->category->findById($input->categoryId());

        return new Product(
            id: $this->generator->nextId(),
            name: $input->name(),
            status: $input->status(),
            description: $input->description(),
            category: $category,
            code: $input->code(),
            seo: $input->seo(),
            signature: $signature,
        );
    }
}
