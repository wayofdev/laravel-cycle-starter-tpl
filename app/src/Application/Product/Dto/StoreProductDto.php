<?php

declare(strict_types=1);

namespace Application\Product\Dto;

use Application\Product\Dto\Category\StoreCategoryDto;
use Application\Product\Dto\Code\StoreCodeDto;
use Application\Product\Dto\Seo\StoreSeoDto;
use Domain\Product\Status;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Product',
    description: 'Product data for storing a new product.'
)]
final class StoreProductDto
{
    #[OAT\Property(
        description: 'Name of the product.',
        example: 'Awesome Jacket'
    )]
    public string $name;

    #[OAT\Property(
        description: 'Is product enabled and shown on site?',
        example: 'true',
    )]
    public Status $status;

    #[OAT\Property(
        description: 'Description of the product.',
        example: 'This is an awesome jacket'
    )]
    public string $description;

    #[OAT\Property(schema: StoreCategoryDto::class)]
    public StoreCategoryDto $category;

    #[OAT\Property(schema: StoreCodeDto::class)]
    public StoreCodeDto $code;

    #[OAT\Property(schema: StoreSeoDto::class)]
    public ?StoreSeoDto $seo;
}
