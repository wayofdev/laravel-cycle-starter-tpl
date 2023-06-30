<?php

declare(strict_types=1);

namespace Application\Client\Dto;

use Application\Auth\Dto\AuthAssembler;
use Domain\Client\Client;

final readonly class ClientAssembler
{
    public function __construct(
        private AuthAssembler $auth
    ) {
    }

    public function toViewClientDto(Client $client): ViewClientDto
    {
        $dto = new ViewClientDto();
        $dto->incrementalId = $client->incrementalId();
        $dto->id = $client->id()->toString();
        $dto->userId = $client->userId()?->toString();
        $dto->email = $client->email();
        $dto->username = $client->username();
        $dto->firstName = $client->firstName();
        $dto->lastName = $client->lastName();
        $dto->company = $client->company();
        $dto->created = $this->auth->toAuthSignatureDto($client->created());
        $dto->updated = $this->auth->toAuthSignatureDto($client->updated());
        $dto->deleted = null;

        if (null !== $client->deleted()) {
            $dto->deleted = $this->auth->toAuthSignatureDto($client->deleted());
        }

        return $dto;
    }
}
