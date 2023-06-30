<?php

declare(strict_types=1);

namespace Domain\Product\Contracts;

use Domain\Product\Factories\ProductInput;
use Domain\Product\Product;

interface ProductFactory
{
    public function create(ProductInput $input): Product;
}
