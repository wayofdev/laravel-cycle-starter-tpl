<?php

declare(strict_types=1);

namespace Application\Auth\Dto;

use Domain\Auth\Footprint;
use Domain\Auth\Signature;

final class AuthAssembler
{
    public function toAuthSignatureDto(Signature $signature): SignatureDto
    {
        $dto = new SignatureDto();
        $dto->at = $signature->at();
        $dto->by = $this->toAuthFootprintDto($signature->by());

        return $dto;
    }

    public function toAuthFootprintDto(?Footprint $footprint): FootprintDto
    {
        $dto = new FootprintDto();

        if (null === $footprint) {
            return $dto;
        }

        $dto->id = $footprint->id()->toString();
        $dto->realm = $footprint->realm();
        $dto->party = $footprint->party();

        return $dto;
    }
}
