<?php

declare(strict_types=1);

namespace Application\Category\Services;

use Application\Category\Commands\UpdateCategory;
use Application\Category\Dto\CategoryAssembler;
use Application\Category\Dto\ViewCategoryDto;
use Domain\Auth\Signature;
use Domain\Category\CategoryRepository;
use Lcobucci\Clock\Clock;
use Throwable;

final readonly class UpdateCategoryService
{
    public function __construct(
        private CategoryRepository $repository,
        private CategoryAssembler $assembler,
        private Clock $clock
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(UpdateCategory $command): ViewCategoryDto
    {
        $category = $command->category();
        $signature = new Signature($this->clock->now(), $command->footprint());

        if (isset($command->dto()->name)) {
            $category->changeName($command->dto()->name, $signature);
        }

        if (isset($command->dto()->gender)) {
            $category->changeGender($command->dto()->gender, $signature);
        }

        // @phpstan-ignore-next-line
        $this->repository->persist($category);

        return $this->assembler->toViewCategoryDto($category);
    }
}
