<?php

declare(strict_types=1);

namespace Application\Product\Services;

use Application\Product\Commands\StoreProduct;
use Application\Product\Dto\ProductAssembler;
use Application\Product\Dto\ViewProductDto;
use Domain\Product\Factories\FromRequestProductFactory;
use Domain\Product\ProductRepository;
use Throwable;

final readonly class StoreProductService
{
    public function __construct(
        private ProductRepository $repository,
        private FromRequestProductFactory $factory,
        private ProductAssembler $assembler
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(StoreProduct $command): ViewProductDto
    {
        $product = $this->factory->create(
            $command->toProductInput()
        );

        // @todo add persist method into interface
        // @phpstan-ignore-next-line
        $this->repository->persist($product);

        return $this->assembler->toViewProductDto($product);
    }
}
