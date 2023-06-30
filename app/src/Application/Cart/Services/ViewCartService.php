<?php

declare(strict_types=1);

namespace Application\Cart\Services;

use Application\Cart\Commands\ViewCart;
use Application\Cart\Dto\CartAssembler;
use Application\Cart\Dto\ViewCartDto;

final readonly class ViewCartService
{
    public function __construct(
        private CartAssembler $assembler
    ) {
    }

    public function handle(ViewCart $command): ViewCartDto
    {
        return $this->assembler->toViewCartDto($command->cart());
    }
}
