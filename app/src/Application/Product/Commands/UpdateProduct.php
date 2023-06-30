<?php

declare(strict_types=1);

namespace Application\Product\Commands;

use Application\Product\Dto\UpdateProductDto;
use Assert\AssertionFailedException;
use Domain\Auth\Footprint;
use Domain\Product\Code\Code;
use Domain\Product\Product;
use Domain\Product\Seo;
use WayOfDev\Auth\Providers\TokenFootprint;

use function get_object_vars;

final readonly class UpdateProduct extends ProductCommand
{
    public function __construct(
        private Product $product,
        private UpdateProductDto $dto,
        private TokenFootprint $tokenFootprint
    ) {
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function dto(): UpdateProductDto
    {
        return $this->dto;
    }

    public function code(): ?Code
    {
        if (! isset($this->dto->code)) {
            return null;
        }

        return Code::fromArray(get_object_vars($this->dto->code));
    }

    public function seo(): ?Seo
    {
        if (! isset($this->dto->seo)) {
            return null;
        }

        return Seo::fromArray(get_object_vars($this->dto->seo));
    }

    /**
     * @throws AssertionFailedException
     */
    public function footprint(): Footprint
    {
        return $this->fromTokenFootprint($this->tokenFootprint);
    }
}
