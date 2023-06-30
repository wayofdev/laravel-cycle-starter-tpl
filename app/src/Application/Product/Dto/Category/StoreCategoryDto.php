<?php

declare(strict_types=1);

namespace Application\Product\Dto\Category;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    schema: 'StoreCategoryToProductDto',
    title: 'Category',
    description: 'Category data.'
)]
final class StoreCategoryDto
{
    #[OAT\Property(format: 'string', example: '10ab5df0-693a-4cd8-8ed5-1e702947d4d0')]
    public string $id;
}
