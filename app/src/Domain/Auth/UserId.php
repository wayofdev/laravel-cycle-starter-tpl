<?php

declare(strict_types=1);

namespace Domain\Auth;

use Assert\AssertionFailedException;
use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;
use WayOfDev\EventSourcing\Events\Concerns\AggregatableRootId;

final class UserId implements AggregateRootId
{
    use AggregatableRootId;

    /**
     * @throws AssertionFailedException
     */
    public static function create(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $aggregateRootId): static
    {
        return new self($aggregateRootId);
    }
}
