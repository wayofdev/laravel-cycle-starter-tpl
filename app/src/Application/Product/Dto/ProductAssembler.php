<?php

declare(strict_types=1);

namespace Application\Product\Dto;

use Application\Auth\Dto\AuthAssembler;
use Application\Category\Dto\ViewCategoryDto;
use Application\Product\Dto\Code\ViewCodeDto;
use Application\Product\Dto\Seo\ViewSeoDto;
use Domain\Category\Category;
use Domain\Product\Code\Code;
use Domain\Product\Product;
use Domain\Product\Seo;

final readonly class ProductAssembler
{
    public function __construct(
        private AuthAssembler $auth
    ) {
    }

    public function toViewProductDto(Product $product): ViewProductDto
    {
        $dto = new ViewProductDto();
        $dto->incrementalId = $product->incrementalId();
        $dto->id = $product->id()->toString();
        $dto->name = $product->name();
        $dto->status = $product->status();
        $dto->description = $product->description();
        $dto->category = $this->toCategoryDto($product->category());
        $dto->code = $this->toCodeDto($product->code());
        $dto->seo = $this->toSeoDto($product->seo());
        $dto->created = $this->auth->toAuthSignatureDto($product->created());
        $dto->updated = $this->auth->toAuthSignatureDto($product->updated());
        $dto->deleted = null;

        if (null !== $product->deleted()) {
            $dto->deleted = $this->auth->toAuthSignatureDto($product->deleted());
        }

        return $dto;
    }

    private function toCategoryDto(Category $category): ViewCategoryDto
    {
        $dto = new ViewCategoryDto();

        $dto->id = $category->id()->toString();

        return $dto;
    }

    private function toCodeDto(Code $code): ViewCodeDto
    {
        $dto = new ViewCodeDto();

        foreach ($code->toArray() as $key => $value) {
            $dto->{$key} = $value;
        }

        return $dto;
    }

    private function toSeoDto(Seo $seo): ViewSeoDto
    {
        $dto = new ViewSeoDto();

        foreach ($seo->toArray() as $key => $value) {
            $dto->{$key} = $value;
        }

        return $dto;
    }
}
