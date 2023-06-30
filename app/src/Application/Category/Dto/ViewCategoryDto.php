<?php

declare(strict_types=1);

namespace Application\Category\Dto;

use Application\Auth\Dto\SignatureDto;
use Domain\Shared\Gender;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Category',
    description: 'Category response data.'
)]
final class ViewCategoryDto
{
    #[OAT\Property(
        format: 'int64',
        example: 1
    )]
    public int $incrementalId;

    #[OAT\Property(format: 'uuid')]
    public string $id;

    #[OAT\Property(example: 'Men Jackets')]
    public string $name;

    #[OAT\Property(
        description: 'Gender of the category.',
        type: 'string',
        example: 'male'
    )]
    public Gender $gender;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $created;

    #[OAT\Property(schema: SignatureDto::class)]
    public SignatureDto $updated;

    #[OAT\Property(schema: SignatureDto::class)]
    public ?SignatureDto $deleted;
}
