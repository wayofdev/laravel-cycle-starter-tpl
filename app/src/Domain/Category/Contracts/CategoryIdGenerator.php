<?php

declare(strict_types=1);

namespace Domain\Category\Contracts;

use Domain\Category\CategoryId;

interface CategoryIdGenerator
{
    public function nextId(): CategoryId;
}
