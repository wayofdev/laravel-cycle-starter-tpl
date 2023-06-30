<?php

declare(strict_types=1);

namespace Application\Cart\Dto;

use Application\Auth\Dto\AuthAssembler;
use Domain\Cart\Cart;

final readonly class CartAssembler
{
    public function __construct(
        private AuthAssembler $auth
    ) {
    }

    public function toViewCartDto(Cart $cart): ViewCartDto
    {
        $dto = new ViewCartDto();
        $dto->incrementalId = $cart->incrementalId();
        $dto->id = $cart->id()->toString();
        $dto->created = $this->auth->toAuthSignatureDto($cart->created());
        $dto->updated = $this->auth->toAuthSignatureDto($cart->updated());
        $dto->deleted = null;

        if (null !== $cart->deleted()) {
            $dto->deleted = $this->auth->toAuthSignatureDto($cart->deleted());
        }

        return $dto;
    }
}
