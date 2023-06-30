<?php

declare(strict_types=1);

namespace Application\Product\Services;

use Application\Product\Commands\ViewProduct;
use Application\Product\Dto\ProductAssembler;
use Application\Product\Dto\ViewProductDto;

final readonly class ViewProductService
{
    public function __construct(
        private ProductAssembler $assembler
    ) {
    }

    public function handle(ViewProduct $command): ViewProductDto
    {
        return $this->assembler->toViewProductDto($command->product());
    }
}
