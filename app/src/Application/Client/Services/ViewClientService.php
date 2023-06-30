<?php

declare(strict_types=1);

namespace Application\Client\Services;

use Application\Client\Commands\ViewClient;
use Application\Client\Dto\ClientAssembler;
use Application\Client\Dto\ViewClientDto;

final readonly class ViewClientService
{
    public function __construct(
        private ClientAssembler $assembler
    ) {
    }

    public function handle(ViewClient $command): ViewClientDto
    {
        return $this->assembler->toViewClientDto($command->client());
    }
}
