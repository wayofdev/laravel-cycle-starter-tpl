<?php

declare(strict_types=1);

namespace Domain\Product\Contracts;

use Domain\Product\ProductId;

interface ProductIdGenerator
{
    public function nextId(): ProductId;
}
