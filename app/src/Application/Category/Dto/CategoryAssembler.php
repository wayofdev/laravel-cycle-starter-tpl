<?php

declare(strict_types=1);

namespace Application\Category\Dto;

use Application\Auth\Dto\AuthAssembler;
use Domain\Category\Category;

final readonly class CategoryAssembler
{
    public function __construct(
        private AuthAssembler $auth
    ) {
    }

    public function toViewCategoryDto(Category $category): ViewCategoryDto
    {
        $dto = new ViewCategoryDto();
        $dto->incrementalId = $category->incrementalId();
        $dto->id = $category->id()->toString();
        $dto->name = $category->name();
        $dto->gender = $category->gender();
        $dto->created = $this->auth->toAuthSignatureDto($category->created());
        $dto->updated = $this->auth->toAuthSignatureDto($category->updated());
        $dto->deleted = null;

        if (null !== $category->deleted()) {
            $dto->deleted = $this->auth->toAuthSignatureDto($category->deleted());
        }

        return $dto;
    }
}
