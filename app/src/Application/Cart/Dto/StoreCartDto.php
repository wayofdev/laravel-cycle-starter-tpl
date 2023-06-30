<?php

declare(strict_types=1);

namespace Application\Cart\Dto;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Cart',
    description: 'Cart data for storing new category.'
)]
final class StoreCartDto
{
}
