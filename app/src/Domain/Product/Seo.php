<?php

declare(strict_types=1);

namespace Domain\Product;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Embeddable;

#[Embeddable]
class Seo
{
    #[Column(type: 'string', nullable: true, unique: true)]
    private ?string $slug;

    #[Column(type: 'string', nullable: true)]
    private ?string $title;

    #[Column(type: 'string', nullable: true)]
    private ?string $description;

    public static function fromArray(array $data): self
    {
        return new self(
            $data['slug'] ?? null,
            $data['title'] ?? null,
            $data['description'] ?? null
        );
    }

    public function __construct(?string $slug, ?string $title, ?string $description)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
    }

    public function slug(): ?string
    {
        return $this->slug;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    public function merge(self $other): self
    {
        return new self(
            $other->slug ?? $this->slug,
            $other->title ?? $this->title,
            $other->description ?? $this->description
        );
    }
}
