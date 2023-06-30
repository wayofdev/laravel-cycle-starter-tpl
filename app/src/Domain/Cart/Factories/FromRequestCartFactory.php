<?php

declare(strict_types=1);

namespace Domain\Cart\Factories;

use Domain\Auth\Signature;
use Domain\Cart\Cart;
use Domain\Cart\Contracts\CartFactory;
use Domain\Cart\Contracts\CartIdGenerator;
use Lcobucci\Clock\Clock;

final readonly class FromRequestCartFactory implements CartFactory
{
    public function __construct(
        private CartIdGenerator $generator,
        private Clock $clock
    ) {
    }

    public function create(CartInput $input): Cart
    {
        if (null === $input->footprint()) {
            $signature = Signature::empty();
        } else {
            $signature = new Signature($this->clock->now(), $input->footprint());
        }

        return new Cart(
            id: $this->generator->nextId(),
            signature: $signature,
        );
    }
}
