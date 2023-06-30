<?php

declare(strict_types=1);

namespace Domain\Country;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Embeddable;

#[Embeddable]
class Iso
{
    #[Column(type: 'string', unique: true)]
    private string $alpha2;

    #[Column(type: 'string', unique: true)]
    private string $alpha3;

    #[Column(type: 'string', unique: true)]
    private string $numeric;

    public static function fromArray(array $data): self
    {
        return new self(
            $data['alpha2'],
            $data['alpha3'],
            $data['numeric']
        );
    }

    public function __construct(string $alpha2, string $alpha3, string $numeric)
    {
        $this->alpha2 = $alpha2;
        $this->alpha3 = $alpha3;
        $this->numeric = $numeric;
    }

    public function alpha2(): string
    {
        return $this->alpha2;
    }

    public function alpha3(): string
    {
        return $this->alpha3;
    }

    public function numeric(): string
    {
        return $this->numeric;
    }

    public function toArray(): array
    {
        return [
            'alpha2' => $this->alpha2,
            'alpha3' => $this->alpha3,
            'numeric' => $this->numeric,
        ];
    }

    public function merge(self $other): self
    {
        return new self(
            $other->alpha2 ?? $this->alpha2,
            $other->alpha3 ?? $this->alpha3,
            $other->numeric ?? $this->numeric
        );
    }
}
