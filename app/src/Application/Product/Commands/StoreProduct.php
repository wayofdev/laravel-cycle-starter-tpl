<?php

declare(strict_types=1);

namespace Application\Product\Commands;

use Application\Product\Dto\StoreProductDto;
use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use Domain\Product\Code\Code;
use Domain\Product\Factories\ProductInput;
use Domain\Product\Seo;
use Exception;
use WayOfDev\Auth\Providers\TokenFootprint;

final readonly class StoreProduct extends ProductCommand
{
    public function __construct(
        private readonly StoreProductDto $dto,
        private readonly TokenFootprint $tokenFootprint
    ) {
    }

    /**
     * @throws AssertionFailedException
     * @throws Exception
     */
    public function toProductInput(): ProductInput
    {
        return new ProductInput(
            $this->dto->name,
            $this->dto->status,
            $this->dto->description,
            $this->dto->category->id,
            Code::fromArray([
                'sku' => $this->dto->code->sku,
                'ian' => $this->dto->code->ian,
                'upc' => $this->dto->code->upc,
            ]),
            Seo::fromArray([
                'slug' => $this->dto->seo->slug ?? null,
                'title' => $this->dto->seo->title ?? null,
                'description' => $this->dto->seo->description ?? null,
            ]),
            $this->footprint(),
        );
    }

    /**
     * @throws AssertionFailedException
     */
    public function footprint(): Footprint
    {
        return $this->fromTokenFootprint($this->tokenFootprint);
    }
}
