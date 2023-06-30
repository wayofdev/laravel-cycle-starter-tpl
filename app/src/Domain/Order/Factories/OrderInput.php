<?php

declare(strict_types=1);

namespace Domain\Order\Factories;

use Domain\Auth\Footprint;

final readonly class OrderInput
{
    public function __construct(private ?Footprint $footprint)
    {
    }

    public function footprint(): ?Footprint
    {
        return $this->footprint;
    }
}
