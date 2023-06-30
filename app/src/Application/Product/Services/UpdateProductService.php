<?php

declare(strict_types=1);

namespace Application\Product\Services;

use Application\Product\Commands\UpdateProduct;
use Application\Product\Dto\ProductAssembler;
use Application\Product\Dto\ViewProductDto;
use Domain\Auth\Signature;
use Domain\Product\ProductRepository;
use Lcobucci\Clock\Clock;
use Throwable;

final readonly class UpdateProductService
{
    public function __construct(
        private ProductRepository $repository,
        private ProductAssembler $assembler,
        private Clock $clock
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(UpdateProduct $command): ViewProductDto
    {
        $product = $command->product();
        $signature = new Signature($this->clock->now(), $command->footprint());

        if (isset($command->dto()->name)) {
            $product->changeName($command->dto()->name, $signature);
        }

        if (isset($command->dto()->status)) {
            $product->changeStatus($command->dto()->status, $signature);
        }

        if (isset($command->dto()->description)) {
            $product->changeDescription($command->dto()->description, $signature);
        }

        if (null !== $command->code()) {
            $product->changeCode($command->code(), $signature);
        }

        if (null !== $command->seo()) {
            $product->changeSeo($command->seo(), $signature);
        }

        // @phpstan-ignore-next-line
        $this->repository->persist($product);

        return $this->assembler->toViewProductDto($product);
    }
}
