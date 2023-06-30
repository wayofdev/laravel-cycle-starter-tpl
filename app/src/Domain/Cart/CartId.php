<?php

declare(strict_types=1);

namespace Domain\Cart;

use Assert\AssertionFailedException;
use Cycle\Database\DatabaseInterface;
use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;
use WayOfDev\EventSourcing\Events\Concerns\AggregatableRootId;

final class CartId implements AggregateRootId
{
    use AggregatableRootId;

    /**
     * @throws AssertionFailedException
     */
    public static function create(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new self($aggregateRootId);
    }

    public static function castValue(string $value, DatabaseInterface $db): self
    {
        return self::fromString($value);
    }
}
