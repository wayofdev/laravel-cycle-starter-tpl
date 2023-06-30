<?php

declare(strict_types=1);

namespace Application\Category\Commands;

use Domain\Category\Category;

final readonly class ViewCategory
{
    public function __construct(private Category $category)
    {
    }

    public function category(): Category
    {
        return $this->category;
    }
}
