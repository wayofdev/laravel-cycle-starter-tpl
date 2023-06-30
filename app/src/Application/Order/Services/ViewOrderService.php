<?php

declare(strict_types=1);

namespace Application\Order\Services;

use Application\Order\Commands\ViewOrder;
use Application\Order\Dto\OrderAssembler;
use Application\Order\Dto\ViewOrderDto;

final readonly class ViewOrderService
{
    public function __construct(
        private OrderAssembler $assembler
    ) {
    }

    public function handle(ViewOrder $command): ViewOrderDto
    {
        return $this->assembler->toViewOrderDto($command->order());
    }
}
