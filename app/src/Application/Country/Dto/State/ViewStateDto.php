<?php

declare(strict_types=1);

namespace Application\Country\Dto\State;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Country state',
    description: 'This schema contains country state.'
)]
final class ViewStateDto
{
    #[OAT\Property(format: 'integer', example: 1)]
    public int $id;

    #[OAT\Property(format: 'string', example: 'TX')]
    public string $code;

    #[OAT\Property(format: 'string', example: 'Texas')]
    public string $name;
}
