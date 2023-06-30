<?php

declare(strict_types=1);

namespace Domain\Category\Contracts;

use Domain\Category\Category;
use Domain\Category\Factories\CategoryInput;

interface CategoryFactory
{
    public function create(CategoryInput $input): Category;
}
