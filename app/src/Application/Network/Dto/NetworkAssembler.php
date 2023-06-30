<?php

declare(strict_types=1);

namespace Application\Network\Dto;

use Application\Auth\Dto\AuthAssembler;
use Domain\Auth\Signature;

final readonly class NetworkAssembler
{
    public function __construct(private AuthAssembler $auth)
    {
    }

    public function toNetworkDto(Signature $signature): NetworkDto
    {
        $dto = new NetworkDto();
        $dto->response = 'PONG';
        $dto->requested = $this->auth->toAuthSignatureDto($signature);

        return $dto;
    }
}
