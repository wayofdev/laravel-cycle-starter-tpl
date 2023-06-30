<?php

declare(strict_types=1);

namespace Domain\Category;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\Embedded;
use Domain\Auth\Signature;
use Domain\Category\Events\CategoryCreated;
use Domain\Shared\Gender;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootId;
use WayOfDev\EventSourcing\Events\Concerns\AggregatableRoot;

#[Entity(repository: CategoryRepository::class)]
class Category implements AggregateRoot
{
    use AggregatableRoot;

    #[Column(type: 'bigPrimary')]
    public int $incrementalId;

    #[Column(type: 'uuid', typecast: [CategoryId::class, 'castValue'], unique: true)]
    private CategoryId $id;

    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'enum(male,female,other)', typecast: [Gender::class, 'castValue'])]
    private Gender $gender;

    #[Embedded(target: Signature::class, prefix: 'created_')]
    private Signature $created;

    #[Embedded(target: Signature::class, prefix: 'updated_')]
    private Signature $updated;

    #[Embedded(target: Signature::class, prefix: 'deleted_')]
    private ?Signature $deleted;

    public function __construct(
        CategoryId $id,
        string $name,
        Gender $gender,
        Signature $signature,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
        $this->created = $signature;
        $this->updated = clone $signature;
        $this->deleted = Signature::empty();

        $this->recordThat(new CategoryCreated($id, $name, $gender, $signature));
    }

    public function aggregateRootId(): AggregateRootId
    {
        return $this->id;
    }

    public function incrementalId(): int
    {
        return $this->incrementalId;
    }

    public function id(): CategoryId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function gender(): Gender
    {
        return $this->gender;
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

    public function changeName(string $name, Signature $signature): void
    {
        $this->name = $name;
        $this->updated = $signature;
    }

    public function changeGender(Gender $gender, Signature $signature): void
    {
        $this->gender = $gender;
        $this->updated = $signature;
    }
}
