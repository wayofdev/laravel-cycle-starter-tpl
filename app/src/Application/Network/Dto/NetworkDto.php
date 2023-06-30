<?php

declare(strict_types=1);

namespace Application\Network\Dto;

use Application\Auth\Dto\SignatureDto;

final class NetworkDto
{
    public string $response;

    public SignatureDto $requested;
}
