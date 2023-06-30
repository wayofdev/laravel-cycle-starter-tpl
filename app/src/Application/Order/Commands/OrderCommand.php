<?php

declare(strict_types=1);

namespace Application\Order\Commands;

use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use WayOfDev\Auth\Providers\TokenFootprint;

abstract readonly class OrderCommand
{
    /**
     * @throws AssertionFailedException
     */
    protected function fromTokenFootprint(TokenFootprint $tokenFootprint): Footprint
    {
        return Footprint::fromArray($tokenFootprint->toArray());
    }
}
