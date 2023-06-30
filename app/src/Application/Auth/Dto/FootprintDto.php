<?php

declare(strict_types=1);

namespace Application\Auth\Dto;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Footprint',
    description: 'Footprint data.'
)]
final class FootprintDto
{
    #[OAT\Property(format: 'uuid')]
    public string $id;

    #[OAT\Property(
        format: 'string',
        example: 'user'
    )]
    public string $party;

    #[OAT\Property(
        format: 'string',
        example: 'front-office'
    )]
    public string $realm;
}
