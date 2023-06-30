<?php

declare(strict_types=1);

namespace Application\Network\Commands;

use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use WayOfDev\Auth\Providers\TokenFootprint;

final readonly class Ping
{
    public function __construct(private ?TokenFootprint $footprint)
    {
    }

    /**
     * @throws AssertionFailedException
     */
    public function footprint(): Footprint
    {
        if (null === $this->footprint) {
            return Footprint::random();
        }

        return Footprint::fromArray($this->footprint->toArray());
    }
}
