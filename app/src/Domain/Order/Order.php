<?php

declare(strict_types=1);

namespace Domain\Order;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\Embedded;
use Domain\Auth\Signature;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootId;
use WayOfDev\EventSourcing\Events\Concerns\AggregatableRoot;

#[Entity(repository: OrderRepository::class)]
class Order implements AggregateRoot
{
    use AggregatableRoot;

    #[Column(type: 'bigPrimary')]
    public int $incrementalId;

    #[Column(type: 'uuid', typecast: [OrderId::class, 'castValue'], unique: true)]
    private OrderId $id;

    #[Embedded(target: Signature::class, prefix: 'created_')]
    private Signature $created;

    #[Embedded(target: Signature::class, prefix: 'updated_')]
    private Signature $updated;

    #[Embedded(target: Signature::class, prefix: 'deleted_')]
    private ?Signature $deleted;

    public function __construct(
        OrderId $id,
        Signature $signature,
    ) {
        $this->id = $id;
        $this->created = $signature;
        $this->updated = clone $signature;
        $this->deleted = Signature::empty();
    }

    public function aggregateRootId(): AggregateRootId
    {
        return $this->id;
    }

    public function incrementalId(): int
    {
        return $this->incrementalId;
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function created(): Signature
    {
        return $this->created;
    }

    public function updated(): Signature
    {
        return $this->updated;
    }

    public function deleted(): ?Signature
    {
        if (! $this->deleted?->defined()) {
            return null;
        }

        return $this->deleted;
    }
}
