<?php

declare(strict_types=1);

namespace Application\Client\Dto;

use Application\Auth\Dto\SignatureDto;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Client',
    description: 'Client response data.'
)
]
final class ViewClientDto
{
    #[OAT\Property(
        format: 'int64',
        example: 1
    )]
    public int $incrementalId;

    #[OAT\Property(format: 'uuid')]
    public ?string $id;

    #[OAT\Property(format: 'uuid')]
    public ?string $userId;

    #[OAT\Property(example: 'john.doe@example.com')]
    public ?string $email;

    #[OAT\Property(example: 'john-doe')]
    public ?string $username;

    #[OAT\Property(example: 'John')]
    public ?string $firstName;

    #[OAT\Property(example: 'Doe')]
    public ?string $lastName;

    #[OAT\Property(example: 'Big Fat Company LLC')]
    public ?string $company;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $created;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $updated;

    #[OAT\Property(schema: SignatureDto::class)]
    public ?SignatureDto $deleted;
}
