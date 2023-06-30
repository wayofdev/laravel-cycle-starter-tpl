<?php

declare(strict_types=1);

namespace Application\Category\Commands;

use Application\Category\Dto\StoreCategoryDto;
use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use Domain\Category\Factories\CategoryInput;
use WayOfDev\Auth\Providers\TokenFootprint;

final readonly class StoreCategory extends CategoryCommand
{
    public function __construct(
        private StoreCategoryDto $dto,
        private TokenFootprint $tokenFootprint
    ) {
    }

    /**
     * @throws AssertionFailedException
     */
    public function toCategoryInput(): CategoryInput
    {
        return new CategoryInput(
            $this->dto->name,
            $this->dto->gender,
            $this->footprint(),
        );
    }

    /**
     * @throws AssertionFailedException
     */
    public function footprint(): Footprint
    {
        return $this->fromTokenFootprint($this->tokenFootprint);
    }
}
