<?php

declare(strict_types=1);

namespace Application\Product\Dto;

use Application\Product\Dto\Code\UpdateCodeDto;
use Application\Product\Dto\Seo\UpdateSeoDto;
use Domain\Product\Status;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Product',
    description: 'Product data for storing a new product.'
)]
final class UpdateProductDto
{
    #[OAT\Property(
        description: 'Name of the product.',
        example: 'Awesome Jacket'
    )]
    public ?string $name;

    #[OAT\Property(
        description: 'Is product enabled and shown on site?',
        example: 'true',
    )]
    public ?Status $status;

    #[OAT\Property(
        description: 'Description of the product.',
        example: 'This is an awesome jacket'
    )]
    public ?string $description;

    #[OAT\Property(schema: UpdateCodeDto::class)]
    public ?UpdateCodeDto $code;

    #[OAT\Property(schema: UpdateSeoDto::class)]
    public ?UpdateSeoDto $seo;
}
