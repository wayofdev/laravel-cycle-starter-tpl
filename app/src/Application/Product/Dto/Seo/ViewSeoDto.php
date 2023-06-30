<?php

declare(strict_types=1);

namespace Application\Product\Dto\Seo;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Seo',
    description: 'Seo data.'
)]
final class ViewSeoDto
{
    #[OAT\Property(format: 'string', example: 'awesome-jacket')]
    public ?string $slug;

    #[OAT\Property(format: 'string', example: 'Awesome Jacket')]
    public ?string $title;

    #[OAT\Property(format: 'string', example: 'This is an awesome jacket')]
    public ?string $description;
}
