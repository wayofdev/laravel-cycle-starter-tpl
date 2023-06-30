<?php

declare(strict_types=1);

namespace Domain\Client\Events;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Auth\UserId;
use Domain\Client\ClientId;
use Domain\Client\Name;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use JsonSerializable;

final readonly class ClientCreated implements SerializablePayload, JsonSerializable
{
    /**
     * @throws AssertionFailedException
     */
    public static function fromPayload(array $payload): static
    {
        return new self(
            ClientId::fromString($payload['id']),
            UserId::fromString($payload['user_id']),
            $payload['email'],
            $payload['username'],
            Name::fromArray([
                'first_name' => $payload['name']['first_name'],
                'last_name' => $payload['name']['last_name'],
            ]),
            $payload['company'],
            Signature::fromArray($payload['signature'])
        );
    }

    public function __construct(
        private ClientId $id,
        private ?UserId $userId,
        private ?string $email,
        private ?string $username,
        private Name $name,
        private ?string $company,
        private Signature $signature
    ) {
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id->toString(),
            'user_id' => $this->userId?->toString(),
            'email' => $this->email,
            'username' => $this->username,
            'name' => $this->name->toArray(),
            'company' => $this->company,
            'signature' => $this->signature->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toPayload();
    }
}
