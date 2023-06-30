<?php

declare(strict_types=1);

namespace Application\Product\Commands;

use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use WayOfDev\Auth\Providers\TokenFootprint;

abstract readonly class ProductCommand
{
    /**
     * @throws AssertionFailedException
     */
    protected function fromTokenFootprint(TokenFootprint $tokenFootprint): Footprint
    {
        return Footprint::fromArray($tokenFootprint->toArray());
    }
}
