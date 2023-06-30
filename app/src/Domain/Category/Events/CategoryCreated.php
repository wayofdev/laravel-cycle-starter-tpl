<?php

declare(strict_types=1);

namespace Domain\Category\Events;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Category\CategoryId;
use Domain\Shared\Gender;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use JsonSerializable;

final readonly class CategoryCreated implements SerializablePayload, JsonSerializable
{
    /**
     * @throws AssertionFailedException
     */
    final public static function fromPayload(array $payload): static
    {
        return new self(
            CategoryId::fromString($payload['id']),
            $payload['name'],
            Gender::fromString($payload['gender']),
            Signature::fromArray($payload['signature'])
        );
    }

    /**
     * @phpstan-consistent-constructor
     */
    public function __construct(
        private CategoryId $id,
        private string $name,
        private Gender $gender,
        private Signature $signature
    ) {
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name,
            'gender' => $this->gender->toString(),
            'signature' => $this->signature->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toPayload();
    }
}
