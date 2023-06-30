<?php

declare(strict_types=1);

namespace Application\Category\Services;

use Application\Category\Commands\StoreCategory;
use Application\Category\Dto\CategoryAssembler;
use Application\Category\Dto\ViewCategoryDto;
use Domain\Category\CategoryRepository;
use Domain\Category\Factories\FromRequestCategoryFactory;
use Throwable;

final readonly class StoreCategoryService
{
    public function __construct(
        private CategoryRepository $repository,
        private FromRequestCategoryFactory $factory,
        private CategoryAssembler $assembler
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(StoreCategory $command): ViewCategoryDto
    {
        $product = $this->factory->create(
            $command->toCategoryInput()
        );

        // @phpstan-ignore-next-line
        $this->repository->persist($product);

        return $this->assembler->toViewCategoryDto($product);
    }
}
