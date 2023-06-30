<?php

declare(strict_types=1);

namespace Domain\Product;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Cycle\Annotated\Annotation\Relation\Embedded;
use Domain\Auth\Signature;
use Domain\Category\Category;
use Domain\Product\Code\Code;
use Domain\Product\Events\ProductCreated;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootId;
use WayOfDev\EventSourcing\Events\Concerns\AggregatableRoot;

#[Entity(repository: ProductRepository::class)]
class Product implements AggregateRoot
{
    use AggregatableRoot;

    #[Column(type: 'bigPrimary')]
    public int $incrementalId;

    #[Column(type: 'uuid', typecast: [ProductId::class, 'castValue'], unique: true)]
    private ProductId $id;

    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'enum(active,disabled,hidden)', default: 'active', typecast: [Status::class, 'castValue'])]
    private Status $status;

    #[Column(type: 'text')]
    private string $description;

    #[BelongsTo(target: Category::class, innerKey: 'category_id', outerKey: 'incremental_id')]
    private Category $category;

    #[Embedded(target: Code::class, prefix: 'code_')]
    private Code $code;

    #[Embedded(target: Seo::class, prefix: 'seo_')]
    private Seo $seo;

    #[Embedded(target: Signature::class, prefix: 'created_')]
    private Signature $created;

    #[Embedded(target: Signature::class, prefix: 'updated_')]
    private Signature $updated;

    #[Embedded(target: Signature::class, prefix: 'deleted_')]
    private ?Signature $deleted;

    public function __construct(
        ProductId $id,
        string $name,
        Status $status,
        string $description,
        Category $category,
        Code $code,
        Seo $seo,
        Signature $signature,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->description = $description;
        $this->category = $category;
        $this->code = $code;
        $this->seo = $seo;
        $this->created = $signature;
        $this->updated = clone $signature;
        $this->deleted = Signature::empty();

        $this->recordThat(new ProductCreated(
            $id,
            $name,
            $status,
            $description,
            $category,
            $code,
            $seo,
            $signature
        ));
    }

    public function aggregateRootId(): AggregateRootId
    {
        return $this->id;
    }

    public function incrementalId(): int
    {
        return $this->incrementalId;
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function category(): Category
    {
        return $this->category;
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function seo(): Seo
    {
        return $this->seo;
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

    public function changeStatus(Status $status, Signature $signature): void
    {
        $this->status = $status;
        $this->updated = $signature;
    }

    public function changeDescription(string $description, Signature $signature): void
    {
        $this->description = $description;
        $this->updated = $signature;
    }

    public function changeCategory(Category $category, Signature $signature): void
    {
        $this->category = $category;
        $this->updated = $signature;
    }

    public function changeCode(Code $code, Signature $signature): void
    {
        $this->code = $this->code->merge($code);
        $this->updated = $signature;
    }

    public function changeSeo(Seo $seo, Signature $signature): void
    {
        $this->seo = $this->seo->merge($seo);
        $this->updated = $signature;
    }
}
