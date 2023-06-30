<?php

declare(strict_types=1);

namespace Application\Country\Dto\Iso;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'ISO 3166-1 country codes',
    description: 'This schema contains ISO 3166-1 country codes.'
)]
final class ViewIsoDto
{
    #[OAT\Property(format: 'string', example: 'LV')]
    public ?string $alpha2;

    #[OAT\Property(format: 'string', example: 'LVA')]
    public ?string $alpha3;

    #[OAT\Property(format: 'string', example: '428')]
    public ?string $numeric;
}
