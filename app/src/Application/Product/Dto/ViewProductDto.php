<?php

declare(strict_types=1);

namespace Application\Product\Dto;

use Application\Auth\Dto\SignatureDto;
use Application\Category\Dto\ViewCategoryDto;
use Application\Product\Dto\Code\ViewCodeDto;
use Application\Product\Dto\Seo\ViewSeoDto;
use Domain\Product\Status;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Product',
    description: 'Product response data.'
)]
final class ViewProductDto
{
    #[OAT\Property(
        format: 'int64',
        example: 1
    )]
    public int $incrementalId;

    #[OAT\Property(format: 'uuid')]
    public string $id;

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

    #[OAT\Property(schema: ViewCategoryDto::class)]
    public ViewCategoryDto $category;

    #[OAT\Property(schema: ViewCodeDto::class)]
    public ViewCodeDto $code;

    #[OAT\Property(schema: ViewSeoDto::class)]
    public ViewSeoDto $seo;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $created;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $updated;

    #[OAT\Property(schema: SignatureDto::class)]
    public ?SignatureDto $deleted;
}
