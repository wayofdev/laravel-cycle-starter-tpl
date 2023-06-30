<?php

declare(strict_types=1);

namespace Application\Category\Dto;

use Domain\Shared\Gender;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Category',
    description: 'Category data for updating category.'
)]
final class UpdateCategoryDto
{
    #[OAT\Property(
        description: 'Name of the product.',
        example: 'Awesome Jacket'
    )]
    public ?string $name;

    #[OAT\Property(
        description: 'Gender of the category.',
        type: 'string',
        example: 'male'
    )]
    public ?Gender $gender;
}
