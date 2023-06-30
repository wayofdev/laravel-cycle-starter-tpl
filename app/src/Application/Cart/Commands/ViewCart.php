<?php

declare(strict_types=1);

namespace Application\Cart\Commands;

use Domain\Cart\Cart;

final readonly class ViewCart
{
    public function __construct(private Cart $cart)
    {
    }

    public function cart(): Cart
    {
        return $this->cart;
    }
}
