<?php

declare(strict_types=1);

namespace Domain\Category\Factories;

use Domain\Auth\Signature;
use Domain\Category\Category;
use Domain\Category\Contracts\CategoryFactory;
use Domain\Category\Contracts\CategoryIdGenerator;
use Lcobucci\Clock\Clock;

final readonly class FromRequestCategoryFactory implements CategoryFactory
{
    public function __construct(
        private CategoryIdGenerator $generator,
        private Clock $clock
    ) {
    }

    public function create(CategoryInput $input): Category
    {
        $signature = new Signature($this->clock->now(), $input->footprint());

        return new Category(
            id: $this->generator->nextId(),
            name: $input->name(),
            gender: $input->gender(),
            signature: $signature,
        );
    }
}
