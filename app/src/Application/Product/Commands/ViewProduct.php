<?php

declare(strict_types=1);

namespace Application\Product\Commands;

use Domain\Product\Product;

final readonly class ViewProduct
{
    public function __construct(private Product $product)
    {
    }

    public function product(): Product
    {
        return $this->product;
    }
}
