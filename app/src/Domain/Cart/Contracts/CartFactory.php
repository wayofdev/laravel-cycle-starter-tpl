<?php

declare(strict_types=1);

namespace Domain\Cart\Contracts;

use Domain\Cart\Cart;
use Domain\Cart\Factories\CartInput;

interface CartFactory
{
    public function create(CartInput $input): Cart;
}
