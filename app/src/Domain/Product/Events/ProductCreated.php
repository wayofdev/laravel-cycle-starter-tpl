<?php

declare(strict_types=1);

namespace Domain\Product\Events;

use Assert\AssertionFailedException;
use Domain\Auth\Signature;
use Domain\Category\Category;
use Domain\Product\Code\Code;
use Domain\Product\ProductId;
use Domain\Product\Seo;
use Domain\Product\Status;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Exception;
use JsonSerializable;

final readonly class ProductCreated implements SerializablePayload, JsonSerializable
{
    /**
     * @throws AssertionFailedException
     * @throws Exception
     */
    public static function fromPayload(array $payload): static
    {
        return new self(
            ProductId::fromString($payload['id']),
            $payload['name'],
            Status::fromString($payload['status']),
            $payload['description'],
            $payload['category'],
            Code::fromArray($payload['code']),
            Seo::fromArray($payload['seo']),
            Signature::fromArray($payload['signature'])
        );
    }

    public function __construct(
        private ProductId $id,
        private string $name,
        private Status $status,
        private string $description,
        private Category $category,
        private Code $code,
        private Seo $seo,
        private Signature $signature
    ) {
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'category' => $this->category,
            'code' => $this->code->toArray(),
            'seo' => $this->seo->toArray(),
            'signature' => $this->signature->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toPayload();
    }
}
