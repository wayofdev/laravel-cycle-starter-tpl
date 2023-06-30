<?php

declare(strict_types=1);

namespace Application\Order\Dto;

use Application\Auth\Dto\AuthAssembler;
use Domain\Order\Order;

final readonly class OrderAssembler
{
    public function __construct(
        private AuthAssembler $auth
    ) {
    }

    public function toViewOrderDto(Order $order): ViewOrderDto
    {
        $dto = new ViewOrderDto();
        $dto->incrementalId = $order->incrementalId();
        $dto->id = $order->id()->toString();
        $dto->created = $this->auth->toAuthSignatureDto($order->created());
        $dto->updated = $this->auth->toAuthSignatureDto($order->updated());
        $dto->deleted = null;

        if (null !== $order->deleted()) {
            $dto->deleted = $this->auth->toAuthSignatureDto($order->deleted());
        }

        return $dto;
    }
}
