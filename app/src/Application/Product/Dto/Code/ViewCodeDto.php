<?php

declare(strict_types=1);

namespace Application\Product\Dto\Code;

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'Code',
    description: 'Code data.'
)]
final class ViewCodeDto
{
    #[OAT\Property(format: 'string', example: 'AWSP123')]
    public ?string $sku;

    #[OAT\Property(format: 'string', example: '5901234123457')]
    public ?string $ian;

    #[OAT\Property(format: 'string', example: '012345678905')]
    public ?string $upc;
}
