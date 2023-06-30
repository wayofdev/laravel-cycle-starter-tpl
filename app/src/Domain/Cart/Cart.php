<?php

declare(strict_types=1);

namespace Domain\Cart;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\Embedded;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Domain\Auth\Signature;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootId;
use Illuminate\Support\Collection;
use WayOfDev\EventSourcing\Events\Concerns\AggregatableRoot;

#[Entity(repository: CartRepository::class)]
class Cart implements AggregateRoot
{
    use AggregatableRoot;

    #[Column(type: 'bigPrimary')]
    public int $incrementalId;

    #[Column(type: 'uuid', typecast: [CartId::class, 'castValue'], unique: true)]
    private CartId $id;

    #[Embedded(target: Signature::class, prefix: 'created_')]
    private Signature $created;

    #[Embedded(target: Signature::class, prefix: 'updated_')]
    private Signature $updated;

    #[Embedded(target: Signature::class, prefix: 'deleted_')]
    private ?Signature $deleted;

    #[HasMany(target: Item::class)]
    private Collection $items;

    public function __construct(
        CartId $id,
        Signature $signature,
    ) {
        $this->id = $id;
        $this->created = $signature;
        $this->updated = clone $signature;
        $this->deleted = Signature::empty();

        $this->items = new Collection();
    }

    public function aggregateRootId(): AggregateRootId
    {
        return $this->id;
    }

    public function incrementalId(): int
    {
        return $this->incrementalId;
    }

    public function id(): CartId
    {
        return $this->id;
    }

    public function items(): Collection
    {
        return $this->items;
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
