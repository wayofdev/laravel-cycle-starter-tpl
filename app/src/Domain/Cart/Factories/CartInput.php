<?php

declare(strict_types=1);

namespace Domain\Cart\Factories;

use Domain\Auth\Footprint;

final readonly class CartInput
{
    public function __construct(private ?Footprint $footprint)
    {
    }

    public function footprint(): ?Footprint
    {
        return $this->footprint;
    }
}
