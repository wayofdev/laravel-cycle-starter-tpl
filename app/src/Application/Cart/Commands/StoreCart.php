<?php

declare(strict_types=1);

namespace Application\Cart\Commands;

use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use Domain\Cart\Factories\CartInput;
use WayOfDev\Auth\Providers\TokenFootprint;

final readonly class StoreCart extends CartCommand
{
    public function __construct(
        private ?TokenFootprint $tokenFootprint
    ) {
    }

    /**
     * @throws AssertionFailedException
     */
    public function toCartInput(): CartInput
    {
        return new CartInput(
            $this->footprint(),
        );
    }

    /**
     * @throws AssertionFailedException
     */
    public function footprint(): ?Footprint
    {
        if (null !== $this->tokenFootprint) {
            return $this->fromTokenFootprint($this->tokenFootprint);
        }

        return null;
    }
}
