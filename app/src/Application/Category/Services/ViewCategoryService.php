<?php

declare(strict_types=1);

namespace Application\Category\Services;

use Application\Category\Commands\ViewCategory;
use Application\Category\Dto\CategoryAssembler;
use Application\Category\Dto\ViewCategoryDto;

final readonly class ViewCategoryService
{
    public function __construct(
        private CategoryAssembler $assembler
    ) {
    }

    public function handle(ViewCategory $command): ViewCategoryDto
    {
        return $this->assembler->toViewCategoryDto($command->category());
    }
}
