<?php

declare(strict_types=1);

namespace Application\Category\Dto;

use Domain\Shared\Gender;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Category',
    description: 'Category data for storing new category.'
)]
final class StoreCategoryDto
{
    #[OAT\Property(
        description: 'Name of the product.',
        example: 'Awesome Jacket'
    )]
    public string $name;

    #[OAT\Property(
        description: 'Gender of the category.',
        type: 'string',
        example: 'male'
    )]
    public Gender $gender;
}
