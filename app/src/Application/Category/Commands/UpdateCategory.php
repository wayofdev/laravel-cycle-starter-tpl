<?php

declare(strict_types=1);

namespace Application\Category\Commands;

use Application\Category\Dto\UpdateCategoryDto;
use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use Domain\Category\Category;
use WayOfDev\Auth\Providers\TokenFootprint;

final readonly class UpdateCategory extends CategoryCommand
{
    public function __construct(
        private Category $category,
        private UpdateCategoryDto $dto,
        private TokenFootprint $tokenFootprint
    ) {
    }

    public function category(): Category
    {
        return $this->category;
    }

    public function dto(): UpdateCategoryDto
    {
        return $this->dto;
    }

    /**
     * @throws AssertionFailedException
     */
    public function footprint(): Footprint
    {
        return $this->fromTokenFootprint($this->tokenFootprint);
    }
}
