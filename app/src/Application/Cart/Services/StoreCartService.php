<?php

declare(strict_types=1);

namespace Application\Cart\Services;

use Application\Cart\Commands\StoreCart;
use Application\Cart\Dto\CartAssembler;
use Application\Cart\Dto\ViewCartDto;
use Domain\Cart\CartRepository;
use Domain\Cart\Factories\FromRequestCartFactory;
use Throwable;

final readonly class StoreCartService
{
    public function __construct(
        private CartRepository $repository,
        private FromRequestCartFactory $factory,
        private CartAssembler $assembler
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(StoreCart $command): ViewCartDto
    {
        $product = $this->factory->create(
            $command->toCartInput()
        );

        // @phpstan-ignore-next-line
        $this->repository->persist($product);

        return $this->assembler->toViewCartDto($product);
    }
}
